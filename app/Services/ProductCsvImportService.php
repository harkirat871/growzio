<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductCsvImportService
{
    public const CHUNK_SIZE = 100;

    /**
     * Maps possible CSV column names (normalized) to product field keys.
     * Order matters: first match wins when multiple columns map to same field.
     */
    protected static function getColumnMapping(): array
    {
        return [
            'id' => ['id', 'product_id', 'productid'],
            'name' => ['name', 'product_name', 'productname', 'product', 'title', 'item_name', 'itemname'],
            'company_part_number' => ['company_part_number', 'companypartnumber', 'part_number', 'partnumber', 'part_no', 'partno', 'sku', 'model', 'code'],
            'category' => ['category', 'category_id', 'categoryid', 'category_name', 'categoryname', 'product_category', 'productcategory', 'type', 'group'],
            'product_name_hi' => ['product_name_hi', 'productnamehi', 'name_hi', 'namehi', 'hindi_name'],
            'brand_name' => ['brand_name', 'brandname', 'brand', 'manufacturer', 'vendor'],
            'local_part_number' => ['local_part_number', 'localpartnumber', 'local_part_no', 'lpn'],
            'company_part_number_substitute' => ['company_part_number_substitute', 'companypartnumbersubstitute', 'part_substitute', 'substitute_part'],
            'category_2' => ['category_2', 'category2', 'category_2_id', 'subcategory', 'sub_category'],
            'category_3' => ['category_3', 'category3', 'category_3_id'],
            'category_4' => ['category_4', 'category4', 'category_4_id'],
            'description' => ['description', 'desc', 'details', 'product_description', 'productdescription'],
            'price' => ['price', 'mrp', 'cost', 'amount', 'unit_price', 'unitprice', 'selling_price', 'sellingprice'],
            'stock' => ['stock', 'quantity', 'inventory', 'qty', 'available_stock', 'availablestock'],
            'dlp' => ['dlp', 'dealer_price', 'dealerprice'],
            'unit' => ['unit', 'uom', 'units'],
        ];
    }

    /**
     * Normalize a header/key for matching: lowercase, no spaces/underscores/dashes.
     */
    public static function normalizeColumnName(string $name): string
    {
        $normalized = preg_replace('/[\s_\-]+/', '', $name);

        return strtolower(trim($normalized));
    }

    /**
     * Build a map: normalized_header => field_key for the first row of headers.
     */
    public function buildHeaderMap(array $rawHeaders): array
    {
        $mapping = static::getColumnMapping();
        $headerMap = [];
        $fieldToPossibleNorm = [];

        foreach ($mapping as $fieldKey => $possibleNames) {
            foreach ($possibleNames as $norm) {
                $fieldToPossibleNorm[$fieldKey] = $fieldToPossibleNorm[$fieldKey] ?? [];
                $fieldToPossibleNorm[$fieldKey][] = $norm;
            }
        }

        foreach ($rawHeaders as $index => $raw) {
            $raw = is_string($raw) ? trim($raw) : '';
            $normalized = static::normalizeColumnName($raw);
            if ($normalized === '') {
                continue;
            }
            foreach ($mapping as $fieldKey => $possibleNames) {
                if (in_array($normalized, $possibleNames, true)) {
                    $headerMap[$index] = $fieldKey;
                    break;
                }
            }
        }

        return $headerMap;
    }

    /**
     * Get value for a field from row using header map; use first non-empty if multiple columns map to same field.
     */
    protected function getMappedValue(array $row, string $fieldKey, array $headerMap): ?string
    {
        $indices = array_keys(array_filter($headerMap, fn ($mapped) => $mapped === $fieldKey));
        sort($indices, SORT_NUMERIC);
        foreach ($indices as $colIndex) {
            $v = $row[$colIndex] ?? null;
            if ($v !== null && $v !== '') {
                $v = trim((string) $v);
                if ($v !== '') {
                    return $v;
                }
            }
        }

        return null;
    }

    /**
     * Strip BOM from first cell if present (UTF-8 BOM).
     */
    protected function stripBom(array $row): array
    {
        if (isset($row[0]) && is_string($row[0])) {
            $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
        }

        return $row;
    }

    /**
     * Parse numeric value: strip currency symbols, handle scientific notation.
     */
    protected function parseNumeric(?string $value): ?float
    {
        if ($value === null || trim($value) === '') {
            return null;
        }
        $value = preg_replace('/[^\d.Ee\-+]/', '', trim($value));
        if ($value === '') {
            return null;
        }
        $num = filter_var($value, FILTER_VALIDATE_FLOAT);
        return $num !== false ? $num : null;
    }

    /**
     * Parse integer (e.g. stock).
     */
    protected function parseInteger(?string $value): ?int
    {
        if ($value === null || trim($value) === '') {
            return null;
        }
        $value = preg_replace('/[^\d\-]/', '', trim($value));
        if ($value === '') {
            return null;
        }
        $num = filter_var($value, FILTER_VALIDATE_INT);
        return $num !== false ? $num : null;
    }

    /**
     * Import from a file path (e.g. uploaded file). Returns statistics.
     *
     * @param  string  $path  Full path to CSV file
     * @param  int|null  $userId  User ID to assign as product owner
     * @return array{total: int, imported: int, skipped: int, errors: array<int, string>, general_fallback: array<string, array<int>>}
     */
    public function importFromPath(string $path, ?int $userId = null): array
    {
        $handle = $this->openCsvFile($path);
        if ($handle === null) {
            return [
                'total' => 0,
                'imported' => 0,
                'skipped' => 0,
                'errors' => ['Could not open CSV file.'],
                'general_fallback' => [],
            ];
        }

        $headerRow = fgetcsv($handle);
        if ($headerRow === false) {
            fclose($handle);

            return [
                'total' => 0,
                'imported' => 0,
                'skipped' => 0,
                'errors' => ['CSV file is empty or has no header row.'],
                'general_fallback' => [],
            ];
        }

        $headerRow = $this->stripBom($headerRow);
        $headerRow = array_map(function ($cell) {
            return is_string($cell) ? trim($cell) : '';
        }, $headerRow);

        $headerMap = $this->buildHeaderMap($headerRow);
        $colCount = count($headerRow);

        $stats = [
            'total' => 0,
            'imported' => 0,
            'skipped' => 0,
            'errors' => [],
            'general_fallback' => [],
        ];

        $generalId = Category::getOrCreateGeneral();
        $chunk = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            $row = array_pad($row, $colCount, null);
            $row = array_slice($row, 0, $colCount);

            if ($this->isEmptyRow($row)) {
                continue;
            }

            $stats['total']++;
            $result = $this->processRow($row, $headerMap, $rowNum, $userId, $generalId);

            if ($result['success']) {
                $chunk[] = $result['data'];
                if (! empty($result['general_fallback_levels'])) {
                    $productKey = $result['data']['name'] . ' (' . $result['data']['company_part_number'] . ')';
                    $stats['general_fallback'][$productKey] = $result['general_fallback_levels'];
                }
            } else {
                $stats['skipped']++;
                $stats['errors'][$rowNum] = $result['error'];
            }

            if (count($chunk) >= self::CHUNK_SIZE) {
                $this->persistChunk($chunk);
                $stats['imported'] += count($chunk);
                $chunk = [];
            }
        }

        fclose($handle);

        if (count($chunk) > 0) {
            $this->persistChunk($chunk);
            $stats['imported'] += count($chunk);
        }

        return $stats;
    }

    /**
     * Sample CSV content for unit tests (header + one valid row).
     */
    public static function getSampleCsv(): string
    {
        return "name,company_part_number,category,product_name_hi,brand_name,price,stock,unit\n"
            . "Test Product,TEST-001,Electronics,,BrandX,99.50,10,pcs";
    }

    /**
     * Import from CSV string (for testing).
     *
     * @param  string  $csvContent
     * @param  int|null  $userId
     * @return array{total: int, imported: int, skipped: int, errors: array<int, string>}
     */
    public function importFromString(string $csvContent, ?int $userId = null): array
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'csv_');
        if ($tmpFile === false) {
            return [
                'total' => 0,
                'imported' => 0,
                'skipped' => 0,
                'errors' => ['Could not create temp file.'],
                'general_fallback' => [],
            ];
        }
        file_put_contents($tmpFile, $csvContent);
        $result = $this->importFromPath($tmpFile, $userId);
        @unlink($tmpFile);

        return $result;
    }

    /**
     * Bulk update from CSV: match by id (if present and numeric) or company_part_number, then update only non-empty CSV fields.
     *
     * @param  string  $path  Full path to CSV file
     * @return array{total: int, updated: int, skipped: int, errors: array<int, string>, general_fallback: array<string, array<int>>}
     */
    public function updateFromPath(string $path): array
    {
        $handle = $this->openCsvFile($path);
        if ($handle === null) {
            return [
                'total' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['Could not open CSV file.'],
                'general_fallback' => [],
            ];
        }

        $headerRow = fgetcsv($handle);
        if ($headerRow === false) {
            fclose($handle);

            return [
                'total' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['CSV file is empty or has no header row.'],
                'general_fallback' => [],
            ];
        }

        $headerRow = $this->stripBom($headerRow);
        $headerRow = array_map(function ($cell) {
            return is_string($cell) ? trim($cell) : '';
        }, $headerRow);

        $headerMap = $this->buildHeaderMap($headerRow);
        $colCount = count($headerRow);

        $stats = [
            'total' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => [],
            'general_fallback' => [],
        ];

        $generalId = Category::getOrCreateGeneral();
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            $row = array_pad($row, $colCount, null);
            $row = array_slice($row, 0, $colCount);

            if ($this->isEmptyRow($row)) {
                continue;
            }

            $stats['total']++;
            $result = $this->processRowForUpdate($row, $headerMap, $rowNum, $generalId);

            if ($result['success']) {
                $result['product']->update($result['data']);
                $stats['updated']++;
                if (! empty($result['general_fallback_levels'])) {
                    $productKey = ($result['data']['name'] ?? $result['product']->name) . ' (' . ($result['data']['company_part_number'] ?? $result['product']->company_part_number) . ')';
                    $stats['general_fallback'][$productKey] = $result['general_fallback_levels'];
                }
            } else {
                $stats['skipped']++;
                $stats['errors'][$rowNum] = $result['error'];
            }
        }

        fclose($handle);

        return $stats;
    }

    /**
     * Process one row for bulk update: find product by id or company_part_number, build update data (only non-empty CSV values).
     *
     * @param  int  $generalId  ID of the General category (fallback)
     * @return array{success: bool, product?: Product, data?: array, error?: string, general_fallback_levels?: array<int>}
     */
    protected function processRowForUpdate(array $row, array $headerMap, int $rowNum, int $generalId): array
    {
        $get = function (string $field) use ($row, $headerMap) {
            return $this->getMappedValue($row, $field, $headerMap);
        };

        $idRaw = $get('id');
        $companyPartNumber = $get('company_part_number');

        $product = null;
        if ($idRaw !== null && $idRaw !== '') {
            $id = $this->parseInteger($idRaw);
            if ($id !== null && $id > 0) {
                $product = Product::find($id);
            }
        }
        if ($product === null && ! empty($companyPartNumber)) {
            $product = Product::where('company_part_number', $companyPartNumber)->first();
        }

        if ($product === null) {
            $hint = $idRaw ? "id [{$idRaw}]" : ($companyPartNumber ? "company_part_number [{$companyPartNumber}]" : 'id or company_part_number');
            return ['success' => false, 'error' => "Row {$rowNum}: No product found for {$hint}."];
        }

        $generalFallbackLevels = [];

        // Build update array: only include non-empty CSV values so we don't overwrite with null
        $data = [];

        $name = $get('name');
        if ($name !== null && $name !== '') {
            $data['name'] = trim($name);
        }

        $categoryName = $get('category');
        if ($categoryName !== null && $categoryName !== '') {
            $categoryId = Category::resolveByName($categoryName);
            if ($categoryId === null) {
                $categoryId = $generalId;
                $generalFallbackLevels[] = 1;
            }
            $data['category_id'] = $categoryId;
        } elseif ($categoryName !== null && trim($categoryName) === '') {
            $data['category_id'] = $generalId;
            $generalFallbackLevels[] = 1;
        }

        $category2Name = $get('category_2');
        $category3Name = $get('category_3');
        $category4Name = $get('category_4');
        if ($category2Name !== null && $category2Name !== '') {
            $data['category_2_id'] = $this->resolveCategoryWithFallback($category2Name, $generalId, $generalFallbackLevels, 2);
        }
        if ($category3Name !== null && $category3Name !== '') {
            $data['category_3_id'] = $this->resolveCategoryWithFallback($category3Name, $generalId, $generalFallbackLevels, 3);
        }
        if ($category4Name !== null && $category4Name !== '') {
            $data['category_4_id'] = $this->resolveCategoryWithFallback($category4Name, $generalId, $generalFallbackLevels, 4);
        }

        $productNameHi = $get('product_name_hi');
        if ($productNameHi !== null) {
            $data['product_name_hi'] = $this->emptyToNull($productNameHi);
        }
        $brandName = $get('brand_name');
        if ($brandName !== null) {
            $data['brand_name'] = $this->emptyToNull($brandName);
        }
        $localPartNumber = $get('local_part_number');
        if ($localPartNumber !== null) {
            $data['local_part_number'] = $this->emptyToNull($localPartNumber);
        }
        $companyPartNumberSubst = $get('company_part_number_substitute');
        if ($companyPartNumberSubst !== null) {
            $data['company_part_number_substitute'] = $this->emptyToNull($companyPartNumberSubst);
        }
        $description = $get('description');
        if ($description !== null) {
            $data['description'] = $this->emptyToNull($description);
        }
        $price = $get('price');
        if ($price !== null && $price !== '') {
            $parsed = $this->parseNumeric($price);
            if ($parsed !== null) {
                $data['price'] = $parsed;
            }
        }
        $stock = $get('stock');
        if ($stock !== null && $stock !== '') {
            $parsed = $this->parseInteger($stock);
            if ($parsed !== null) {
                $data['stock'] = $parsed;
            }
        }
        $dlp = $get('dlp');
        if ($dlp !== null && $dlp !== '') {
            $parsed = $this->parseNumeric($dlp);
            if ($parsed !== null) {
                $data['dlp'] = $parsed;
            }
        }
        $unit = $get('unit');
        if ($unit !== null) {
            $data['unit'] = $this->emptyToNull($unit);
        }

        // Only allow updating company_part_number if provided (and not empty)
        $newCpn = $get('company_part_number');
        if ($newCpn !== null && trim($newCpn) !== '') {
            $data['company_part_number'] = trim($newCpn);
        }

        if (empty($data)) {
            return ['success' => false, 'error' => "Row {$rowNum}: No updatable fields provided (at least one field besides id/company_part_number must have a value)."];
        }

        return [
            'success' => true,
            'product' => $product,
            'data' => $data,
            'general_fallback_levels' => $generalFallbackLevels,
        ];
    }

    protected function openCsvFile(string $path)
    {
        $content = file_get_contents($path);
        if ($content === false) {
            return null;
        }
        $content = $this->normalizeLineEndings($content);
        $content = $this->ensureUtf8($content);
        $tmp = tempnam(sys_get_temp_dir(), 'csv_');
        if ($tmp === false) {
            return null;
        }
        file_put_contents($tmp, $content);
        $handle = fopen($tmp, 'r');
        if ($handle === false) {
            @unlink($tmp);
            return null;
        }
        $tmpPath = $tmp;
        register_shutdown_function(function () use ($tmpPath) {
            if (file_exists($tmpPath)) {
                @unlink($tmpPath);
            }
        });

        return $handle;
    }

    protected function normalizeLineEndings(string $content): string
    {
        return preg_replace('/\r\n|\r/', "\n", $content);
    }

    protected function ensureUtf8(string $content): string
    {
        $encoding = mb_detect_encoding($content, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($encoding && $encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
        }

        return $content;
    }

    protected function isEmptyRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }

    /**
     * Process one row into product data or error.
     * When a category does not exist, assigns the product to the "General" category.
     *
     * @param  int  $generalId  ID of the General category (fallback)
     * @return array{success: bool, data?: array, error?: string, general_fallback_levels?: array<int>}
     */
    protected function processRow(array $row, array $headerMap, int $rowNum, ?int $userId, int $generalId): array
    {
        $get = function (string $field) use ($row, $headerMap) {
            return $this->getMappedValue($row, $field, $headerMap);
        };

        $name = $get('name');
        $companyPartNumber = $get('company_part_number');
        $categoryName = $get('category');

        if (empty($name)) {
            return ['success' => false, 'error' => "Row {$rowNum}: Required field 'name' is missing or empty."];
        }
        if (empty($companyPartNumber)) {
            return ['success' => false, 'error' => "Row {$rowNum}: Required field 'company_part_number' is missing or empty."];
        }

        $generalFallbackLevels = [];

        // Category 1: required; if empty or not found → use General
        if (empty($categoryName)) {
            $categoryId = $generalId;
            $generalFallbackLevels[] = 1;
        } else {
            $categoryId = Category::resolveByName($categoryName);
            if ($categoryId === null) {
                $categoryId = $generalId;
                $generalFallbackLevels[] = 1;
            }
        }

        if (Product::where('company_part_number', $companyPartNumber)->exists()) {
            return ['success' => false, 'error' => "Row {$rowNum}: Duplicate company_part_number: [{$companyPartNumber}]."];
        }

        // Categories 2, 3, 4: if specified but not found → use General; if empty → null
        $category2Name = $get('category_2');
        $category3Name = $get('category_3');
        $category4Name = $get('category_4');

        $category2Id = $this->resolveCategoryWithFallback($category2Name, $generalId, $generalFallbackLevels, 2);
        $category3Id = $this->resolveCategoryWithFallback($category3Name, $generalId, $generalFallbackLevels, 3);
        $category4Id = $this->resolveCategoryWithFallback($category4Name, $generalId, $generalFallbackLevels, 4);

        $data = [
            'name' => $name,
            'company_part_number' => $companyPartNumber,
            'category_id' => $categoryId,
            'user_id' => $userId,
            'product_name_hi' => $this->emptyToNull($get('product_name_hi')),
            'brand_name' => $this->emptyToNull($get('brand_name')),
            'local_part_number' => $this->emptyToNull($get('local_part_number')),
            'company_part_number_substitute' => $this->emptyToNull($get('company_part_number_substitute')),
            'category_2_id' => $category2Id,
            'category_3_id' => $category3Id,
            'category_4_id' => $category4Id,
            'description' => $this->emptyToNull($get('description')),
            'price' => $this->parseNumeric($get('price')),
            'stock' => $this->parseInteger($get('stock')),
            'dlp' => $this->parseNumeric($get('dlp')),
            'unit' => $this->emptyToNull($get('unit')),
        ];

        return [
            'success' => true,
            'data' => $data,
            'general_fallback_levels' => $generalFallbackLevels,
        ];
    }

    /**
     * Resolve category by name; if specified but not found, use General and track the level.
     *
     * @param  string|null  $name
     * @param  int  $generalId
     * @param  array<int>  $generalFallbackLevels
     * @param  int  $level
     * @return int|null
     */
    protected function resolveCategoryWithFallback(?string $name, int $generalId, array &$generalFallbackLevels, int $level): ?int
    {
        if ($this->emptyToNull($name) === null) {
            return null;
        }
        $resolved = Category::resolveByName($name);
        if ($resolved !== null) {
            return $resolved;
        }
        $generalFallbackLevels[] = $level;

        return $generalId;
    }

    protected function emptyToNull(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        return trim($value);
    }

    protected function resolveCategoryId(?string $name): ?int
    {
        return Category::resolveByName($name);
    }

    protected function persistChunk(array $chunk): void
    {
        DB::transaction(function () use ($chunk) {
            foreach ($chunk as $data) {
                Product::create($data);
            }
        });
    }
}
