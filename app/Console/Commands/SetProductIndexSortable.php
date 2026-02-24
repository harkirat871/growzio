<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Meilisearch\Client as MeilisearchClient;

/**
 * Set sortable attributes on the Meilisearch products index.
 * Run this to fix: "Attribute `created_at` is not sortable. This index does not have configured sortable attributes."
 *
 * DB alignment: products table has price, last_sold_at, created_at (from migrations).
 * Product::toSearchableArray() sends these as document fields; they must be listed as sortable in Meilisearch.
 */
class SetProductIndexSortable extends Command
{
    protected $signature = 'meilisearch:set-product-sortable';

    protected $description = 'Set sortable attributes on the Product Meilisearch index (price, last_sold_at, created_at)';

    public function handle(): int
    {
        $host = config('scout.meilisearch.host');
        $key = config('scout.meilisearch.key');

        if (! $host) {
            $this->error('Meilisearch host is not configured (scout.meilisearch.host).');
            return self::FAILURE;
        }

        try {
            $client = new MeilisearchClient($host, $key);
        } catch (\Throwable $e) {
            $this->error('Failed to create Meilisearch client: '.$e->getMessage());
            return self::FAILURE;
        }

        $indexName = (new Product)->searchableAs();
        $this->info("Updating index: {$indexName}");

        try {
            $index = $client->index($indexName);
            $index->updateSettings([
                'sortableAttributes' => ['price', 'last_sold_at', 'created_at'],
            ]);
            $this->info('Sortable attributes set: price, last_sold_at, created_at');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to update sortable attributes: '.$e->getMessage());
            return self::FAILURE;
        }
    }
}
