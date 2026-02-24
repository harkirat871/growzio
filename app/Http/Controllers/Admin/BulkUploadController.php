<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductCsvImportService;
use App\Services\ProductZipImageMatchService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BulkUploadController extends Controller
{
    public function __construct(
        protected ProductCsvImportService $importService,
        protected ProductZipImageMatchService $zipImageService
    ) {}

    /**
     * Show the bulk upload form.
     */
    public function showForm(): View
    {
        return view('admin.products.bulk-upload');
    }

    /**
     * Download a CSV template for bulk upload.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="products_bulk_upload_template.csv"',
        ];

        $columns = [
            'name',
            'company_part_number',
            'category',
            'product_name_hi',
            'brand_name',
            'local_part_number',
            'company_part_number_substitute',
            'category_2',
            'category_3',
            'category_4',
            'description',
            'price',
            'stock',
            'dlp',
            'unit',
        ];

        $exampleRow = [
            'Example Product',
            'CPN-001',
            'Electronics',
            'उत्पाद नाम',
            'BrandX',
            'LPN-1',
            'CPN-002',
            'SubCategory1',
            '',
            '',
            'Short product description.',
            '99.00',
            '10',
            '85.00',
            'pcs',
        ];

        return response()->stream(function () use ($columns, $exampleRow) {
            $out = fopen('php://output', 'w');
            fprintf($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($out, $columns);
            fputcsv($out, $exampleRow);
            fclose($out);
        }, 200, $headers);
    }

    /**
     * Download a CSV template for bulk update (includes id and company_part_number for matching).
     */
    public function downloadBulkUpdateTemplate(): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="products_bulk_update_template.csv"',
        ];

        $columns = [
            'id',
            'company_part_number',
            'name',
            'category',
            'product_name_hi',
            'brand_name',
            'local_part_number',
            'company_part_number_substitute',
            'category_2',
            'category_3',
            'category_4',
            'description',
            'price',
            'stock',
            'dlp',
            'unit',
        ];

        $exampleRow = [
            '1',
            'CPN-001',
            'Example Product Updated',
            'Electronics',
            'उत्पाद नाम',
            'BrandX',
            'LPN-1',
            'CPN-002',
            '',
            '',
            '',
            'Updated description.',
            '109.00',
            '20',
            '95.00',
            'pcs',
        ];

        return response()->stream(function () use ($columns, $exampleRow) {
            $out = fopen('php://output', 'w');
            fprintf($out, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel
            fputcsv($out, $columns);
            fputcsv($out, $exampleRow);
            fclose($out);
        }, 200, $headers);
    }

    /**
     * Process the uploaded CSV and update existing products (match by id or company_part_number).
     */
    public function processBulkUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $stats = $this->importService->updateFromPath($path);

        $errorsList = $stats['errors'];
        ksort($errorsList, SORT_NUMERIC);
        $errorMessages = array_values($errorsList);
        $firstErrors = array_slice($errorMessages, 0, 5);

        if ($stats['total'] === 0 && ! empty($errorMessages)) {
            return redirect()
                ->route('admin.products.bulk-upload')
                ->with('error', $errorMessages[0] ?? 'No rows processed.');
        }

        $message = sprintf(
            'Bulk update: %d row(s) processed, %d updated, %d skipped.',
            $stats['total'],
            $stats['updated'],
            $stats['skipped']
        );

        $redirect = redirect()
            ->route('admin.products.bulk-upload')
            ->with('success', $message)
            ->with('import_errors', $firstErrors)
            ->with('import_errors_count', count($errorMessages));

        $generalFallback = $stats['general_fallback'] ?? [];
        if (! empty($generalFallback)) {
            $redirect->with('general_fallback_report', $generalFallback);
        }

        return $redirect;
    }

    /**
     * Process the uploaded CSV and create products.
     */
    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $userId = auth()->id();

        $stats = $this->importService->importFromPath($path, $userId);

        if (isset($stats['errors'][0]) && $stats['total'] === 0 && $stats['imported'] === 0) {
            return redirect()
                ->route('admin.products.bulk-upload')
                ->with('error', $stats['errors'][0]);
        }

        $errorsList = $stats['errors'];
        ksort($errorsList, SORT_NUMERIC);
        $errorMessages = array_values($errorsList);
        $firstErrors = array_slice($errorMessages, 0, 5);

        $message = sprintf(
            'Total rows processed: %d. Imported: %d. Skipped: %d.',
            $stats['total'],
            $stats['imported'],
            $stats['skipped']
        );

        $redirect = redirect()
            ->route('admin.products.index')
            ->with('success', $message)
            ->with('import_errors', $firstErrors)
            ->with('import_errors_count', count($errorMessages));

        $generalFallback = $stats['general_fallback'] ?? [];
        if (! empty($generalFallback)) {
            $redirect->with('general_fallback_report', $generalFallback);
        }

        return $redirect;
    }

    /**
     * Process uploaded ZIP of product images. Two-pass matching: product name first, then company_part_number.
     * Saves matched images to public/products and updates product image_path.
     */
    public function processZipImages(Request $request): RedirectResponse
    {
        $request->validate([
            'zip_file' => ['required', 'file', 'mimes:zip', 'max:102400'], // 100MB
        ]);

        $file = $request->file('zip_file');
        $zipPath = $file->getRealPath();

        $result = $this->zipImageService->processZip($zipPath);

        if (!empty($result['errors'])) {
            return redirect()
                ->route('admin.products.bulk-upload')
                ->with('error', $result['errors'][0])
                ->with('zip_errors', $result['errors']);
        }

        $stats = $result['stats'];
        $publicProductsDir = public_path('products');

        if (!is_dir($publicProductsDir)) {
            mkdir($publicProductsDir, 0755, true);
        }

        $saved = 0;
        foreach ($result['matched'] as $item) {
            $tempPath = $item['temp_path'];
            if (!is_file($tempPath)) {
                continue;
            }
            $ext = strtolower(pathinfo($item['original_name'], PATHINFO_EXTENSION)) ?: 'jpg';
            $safeName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $item['original_name']);
            $destName = time() . '_' . $saved . '_' . $safeName;
            $destPath = $publicProductsDir . DIRECTORY_SEPARATOR . $destName;
            if (copy($tempPath, $destPath)) {
                $relativePath = 'products/' . $destName;
                Product::where('id', $item['product_id'])->update(['image_path' => $relativePath]);
                $saved++;
            }
        }

        if ($result['extract_dir'] !== null && is_dir($result['extract_dir'])) {
            $this->deleteDirectory($result['extract_dir']);
        }

        $message = sprintf(
            'ZIP images: %d total, %d matched by name, %d by part number, %d saved, %d unmatched.',
            $stats['total_images'],
            $stats['matched_by_name'],
            $stats['matched_by_part'],
            $saved,
            $stats['unmatched']
        );

        return redirect()
            ->route('admin.products.bulk-upload')
            ->with('success', $message)
            ->with('zip_unmatched', array_slice($result['unmatched'], 0, 50))
            ->with('zip_unmatched_count', count($result['unmatched']));
    }

    private function deleteDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                @unlink($path);
            }
        }
        @rmdir($dir);
    }
}
