<?php

namespace App\Services;

use App\Models\Product;
use ZipArchive;

/**
 * Two-pass ZIP image matching: PRODUCT NAME (primary) then COMPANY_PART_NUMBER (fallback).
 * Optimized with pre-built hashmaps and queue reduction after first pass.
 */
class ProductZipImageMatchService
{
    /** @var array<string, int> normalized product name -> product id (first wins for duplicates) */
    private array $nameMap = [];

    /** @var array<string, int> normalized company part number -> product id */
    private array $partNumberMap = [];

    /** @var list<array{0: string, 1: int}> normalized name, product id for contains-pass */
    private array $nameList = [];

    /** @var list<array{0: string, 1: int}> normalized part, product id for contains-pass */
    private array $partNumberList = [];

    private const IMAGE_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    private const MAX_ZIP_BYTES = 100 * 1024 * 1024; // 100MB

    public function __construct()
    {
        $this->buildIndexes();
    }

    /**
     * Build name and part-number indexes from database (single query, memory efficient).
     */
    private function buildIndexes(): void
    {
        $products = Product::query()
            ->select(['id', 'name', 'company_part_number'])
            ->get();

        foreach ($products as $product) {
            $normName = $this->normalize($product->name);
            if ($normName !== '' && !isset($this->nameMap[$normName])) {
                $this->nameMap[$normName] = $product->id;
            }
            $this->nameList[] = [$normName, $product->id];

            $normPart = $this->normalize($product->company_part_number ?? '');
            if ($normPart !== '') {
                $this->partNumberMap[$normPart] = $product->id;
                $this->partNumberList[] = [$normPart, $product->id];
            }
        }
    }

    /**
     * Normalize for matching: lowercase, collapse spaces/underscores/hyphens/dots, strip parenthetical suffixes like (1).
     */
    public function normalize(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = preg_replace('/\s*\(\d+\)\s*$/u', '', $value);
        $value = preg_replace('/[\s_\-\.]+/u', '', $value);
        return $value ?? '';
    }

    /**
     * Get base filename without extension (lowercase extension stripped).
     */
    private function baseNameWithoutExtension(string $path): string
    {
        $base = basename($path);
        $pos = strrpos($base, '.');
        if ($pos !== false) {
            return substr($base, 0, $pos);
        }
        return $base;
    }

    /**
     * Check if path is an allowed image file.
     */
    private function isImagePath(string $path): bool
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, self::IMAGE_EXTENSIONS, true);
    }

    /**
     * Process uploaded ZIP: extract, two-pass match, return assignments and unmatched.
     *
     * @return array{
     *   matched: list<array{product_id: int, temp_path: string, original_name: string}>,
     *   unmatched: list<string>,
     *   errors: list<string>,
     *   stats: array{total_images: int, matched_by_name: int, matched_by_part: int, unmatched: int}
     * }
     */
    public function processZip(string $zipPath): array
    {
        $errors = [];
        $matched = [];
        $unmatched = [];

        if (!class_exists(ZipArchive::class)) {
            $errors[] = 'PHP ZipArchive is required.';
            return $this->result($matched, $unmatched, $errors, 0, 0, 0);
        }

        $size = @filesize($zipPath);
        if ($size !== false && $size > self::MAX_ZIP_BYTES) {
            $errors[] = 'ZIP file exceeds 100MB limit.';
            return $this->result($matched, $unmatched, $errors, 0, 0, 0);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::RDONLY) !== true) {
            $errors[] = 'Could not open ZIP file.';
            return $this->result($matched, $unmatched, $errors, 0, 0, 0);
        }

        $extractDir = sys_get_temp_dir() . '/zip_images_' . uniqid('', true);
        if (!@mkdir($extractDir, 0755, true)) {
            $zip->close();
            $errors[] = 'Could not create temporary directory.';
            return $this->result($matched, $unmatched, $errors, 0, 0, 0);
        }

        $imageEntries = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entry = $zip->getNameIndex($i);
            if ($entry === false) {
                continue;
            }
            // Skip directories and macOS __MACOSX
            if (str_ends_with($entry, '/') || str_contains($entry, '__MACOSX')) {
                continue;
            }
            if ($this->isImagePath($entry)) {
                $imageEntries[] = $entry;
            }
        }

        foreach ($imageEntries as $entry) {
            $zip->extractTo($extractDir, $entry);
        }
        $zip->close();

        $imagePaths = [];
        $this->collectExtractedPaths($extractDir, $extractDir, $imagePaths);

        $queue = [];
        foreach ($imagePaths as $fullPath) {
            $base = $this->baseNameWithoutExtension($fullPath);
            $queue[] = [
                'base_normalized' => $this->normalize($base),
                'path' => $fullPath,
                'original_name' => basename($fullPath),
            ];
        }

        $totalImages = count($queue);
        $matchedByName = 0;
        $matchedByPart = 0;

        // —— First pass: match by PRODUCT NAME ——
        $remaining = [];
        foreach ($queue as $item) {
            $baseNorm = $item['base_normalized'];
            $productId = $this->matchByName($baseNorm);
            if ($productId !== null) {
                $matched[] = [
                    'product_id' => $productId,
                    'temp_path' => $item['path'],
                    'original_name' => $item['original_name'],
                ];
                $matchedByName++;
            } else {
                $remaining[] = $item;
            }
        }

        // —— Second pass: match by COMPANY_PART_NUMBER (remaining only) ——
        $stillUnmatched = [];
        foreach ($remaining as $item) {
            $baseNorm = $item['base_normalized'];
            $productId = $this->matchByPartNumber($baseNorm);
            if ($productId !== null) {
                $matched[] = [
                    'product_id' => $productId,
                    'temp_path' => $item['path'],
                    'original_name' => $item['original_name'],
                ];
                $matchedByPart++;
            } else {
                $stillUnmatched[] = $item['original_name'];
            }
        }

        $unmatched = $stillUnmatched;

        return $this->result($matched, $unmatched, $errors, $totalImages, $matchedByName, $matchedByPart, $extractDir);
    }

    /**
     * Recursively collect extracted image file paths (one entry per file).
     * @param array<int, string> $out
     */
    private function collectExtractedPaths(string $baseDir, string $dir, array &$out): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $items = @scandir($dir);
        if ($items === false) {
            return;
        }
        foreach ($items as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $full = $dir . DIRECTORY_SEPARATOR . $entry;
            if (is_dir($full)) {
                $this->collectExtractedPaths($baseDir, $full, $out);
                continue;
            }
            if ($this->isImagePath($full)) {
                $out[] = $full;
            }
        }
    }

    /**
     * Match by product name: exact lookup then contains (filename contains name or name contains filename).
     */
    private function matchByName(string $baseNormalized): ?int
    {
        if ($baseNormalized === '') {
            return null;
        }
        if (isset($this->nameMap[$baseNormalized])) {
            return $this->nameMap[$baseNormalized];
        }
        foreach ($this->nameList as [$normName, $productId]) {
            if ($normName === '') {
                continue;
            }
            if (str_contains($baseNormalized, $normName) || str_contains($normName, $baseNormalized)) {
                return $productId;
            }
        }
        return null;
    }

    /**
     * Match by company part number: exact then contains.
     */
    private function matchByPartNumber(string $baseNormalized): ?int
    {
        if ($baseNormalized === '') {
            return null;
        }
        if (isset($this->partNumberMap[$baseNormalized])) {
            return $this->partNumberMap[$baseNormalized];
        }
        foreach ($this->partNumberList as [$normPart, $productId]) {
            if ($normPart === '') {
                continue;
            }
            if (str_contains($baseNormalized, $normPart) || str_contains($normPart, $baseNormalized)) {
                return $productId;
            }
        }
        return null;
    }

    private function result(
        array $matched,
        array $unmatched,
        array $errors,
        int $totalImages,
        int $matchedByName,
        int $matchedByPart,
        ?string $extractDir = null
    ): array {
        return [
            'matched' => $matched,
            'unmatched' => $unmatched,
            'errors' => $errors,
            'extract_dir' => $extractDir,
            'stats' => [
                'total_images' => $totalImages,
                'matched_by_name' => $matchedByName,
                'matched_by_part' => $matchedByPart,
                'unmatched' => count($unmatched),
            ],
        ];
    }
}
