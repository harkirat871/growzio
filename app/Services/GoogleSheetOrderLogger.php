<?php

namespace App\Services;

use App\Models\Order;
use Google\Client as GoogleClient;
use Google\Service\Sheets;
use Google\Service\Sheets\AddSheetRequest;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;
use Google\Service\Sheets\SheetProperties;
use Google\Service\Sheets\ValueRange;
use Illuminate\Support\Facades\Log;

class GoogleSheetOrderLogger
{
    public function logOrder(Order $order): bool
    {
        $credentialsPath = config('services.google.credentials_path');
        $spreadsheetId = config('services.google.sheet_id');

        if (empty($credentialsPath) || ! is_string($credentialsPath)) {
            Log::warning('Google Sheet order logger: GOOGLE_CREDENTIALS_PATH is missing or invalid.');
            return false;
        }

        $path = $this->resolvePath($credentialsPath);
        if (! is_file($path)) {
            Log::warning('Google Sheet order logger: Credentials file not found.', ['path' => $path]);
            return false;
        }

        if (empty($spreadsheetId) || ! is_string($spreadsheetId)) {
            Log::warning('Google Sheet order logger: GOOGLE_SHEET_ID is missing or invalid.');
            return false;
        }

        try {
            $client = new GoogleClient();
            $client->setAuthConfig($path);
            $client->addScope(Sheets::SPREADSHEETS);
            $service = new Sheets($client);

            $tabName = now()->format('Y-m-d');
            $this->ensureSheetExists($service, $spreadsheetId, $tabName);

            $rows = $this->orderToRows($order);
            $range = "{$tabName}!A:C";
            $body = new ValueRange();
            $body->setValues($rows);
            $service->spreadsheets_values->append(
                $spreadsheetId,
                $range,
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            return true;
        } catch (\Throwable $e) {
            Log::error('Google Sheet order logger failed.', [
                'order_id' => $order->id,
                'message' => $e->getMessage(),
                'exception' => get_class($e),
            ]);
            return false;
        }
    }

    private function resolvePath(string $path): string
    {
        if (str_starts_with($path, '/') || preg_match('#^[A-Za-z]:\\\\#', $path)) {
            return $path;
        }
        return base_path($path);
    }

    private function ensureSheetExists(Sheets $service, string $spreadsheetId, string $tabName): void
    {
        $spreadsheet = $service->spreadsheets->get($spreadsheetId);
        $sheets = $spreadsheet->getSheets() ?: [];
        foreach ($sheets as $sheet) {
            $props = $sheet->getProperties();
            if ($props && $props->getTitle() === $tabName) {
                return;
            }
        }

        $props = new SheetProperties();
        $props->setTitle($tabName);
        $addSheet = new AddSheetRequest();
        $addSheet->setProperties($props);
        $request = new Request();
        $request->setAddSheet($addSheet);
        $batch = new BatchUpdateSpreadsheetRequest();
        $batch->setRequests([$request]);
        $service->spreadsheets->batchUpdate($spreadsheetId, $batch);
    }

    /**
     * @return list<list<string>>
     */
    private function orderToRows(Order $order): array
    {
        $order->loadMissing('items.product');
        $customerName = (string) ($order->guest_name ?? '—');
        $rows = [];
        $first = true;
        foreach ($order->items as $item) {
            $product = $item->product;
            $productName = $product ? $product->name : '—';
            $qty = (string) $item->quantity;
            if ($first) {
                $rows[] = [$customerName, $productName, $qty];
                $first = false;
            } else {
                $rows[] = ['', $productName, $qty];
            }
        }
        $rows[] = [''];
        return $rows;
    }
}
