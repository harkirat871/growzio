<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client as MeilisearchClient;

class SyncSearchSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:sync-search-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Meilisearch settings for the Product index (typo, searchable/filterable/sortable attributes, ranking rules)';

    /**
     * Execute the console command.
     */
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

        // Resolve the Product index name dynamically.
        try {
            /** @var \Laravel\Scout\Searchable $product */
            $product = new \App\Models\Product();
            if (! method_exists($product, 'searchableAs')) {
                $this->error('Product model does not define searchableAs(). Cannot resolve index name.');

                return self::FAILURE;
            }

            $indexName = $product->searchableAs();
        } catch (\Throwable $e) {
            $this->error('Failed to resolve Product index name: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->info("Using Product index: {$indexName}");

        try {
            $index = $client->index($indexName);
            $settings = (array) $index->getSettings();
        } catch (\Throwable $e) {
            $this->error('Failed to fetch Meilisearch settings: '.$e->getMessage());

            return self::FAILURE;
        }

        // --- 0) Sortable attributes first (fixes "Attribute is not sortable" errors) ---
        $desiredSortable = ['price', 'last_sold_at', 'created_at'];
        $originalSortable = $settings['sortableAttributes'] ?? null;
        $this->line('');
        $this->info('Current sortableAttributes:');
        $this->line(json_encode($originalSortable, JSON_PRETTY_PRINT));
        if ($originalSortable !== $desiredSortable) {
            try {
                $index->updateSettings(['sortableAttributes' => $desiredSortable]);
                $this->info('Updated sortableAttributes: '.implode(', ', $desiredSortable));
            } catch (\Throwable $e) {
                $this->error('Failed to update sortableAttributes: '.$e->getMessage());
            }
        } else {
            $this->info('sortableAttributes already configured.');
        }

        // --- 1) Typo tolerance configuration ---

        $originalTypo = isset($settings['typoTolerance']) && is_array($settings['typoTolerance'])
            ? $settings['typoTolerance']
            : [];

        $this->line('');
        $this->info('Current typoTolerance:');
        $this->line(json_encode($originalTypo, JSON_PRETTY_PRINT));

        $newTypo = is_array($originalTypo) ? $originalTypo : [];

        // Ensure enabled = true
        $newTypo['enabled'] = true;

        // Merge minWordSizeForTypos; preserve disableOnWords and disableOnAttributes
        $currentMinSizes = [];
        if (isset($newTypo['minWordSizeForTypos']) && is_array($newTypo['minWordSizeForTypos'])) {
            $currentMinSizes = $newTypo['minWordSizeForTypos'];
        }
        $newTypo['minWordSizeForTypos'] = array_merge($currentMinSizes, [
            'oneTypo' => 2,
            'twoTypos' => 5,
        ]);

        if ($newTypo !== $originalTypo) {
            try {
                $index->updateSettings([
                    'typoTolerance' => $newTypo,
                ]);

                $this->info('');
                $this->info('Updated typoTolerance:');
                $this->line(json_encode($newTypo, JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                $this->error('Failed to update typoTolerance: '.$e->getMessage());
            }
        } else {
            $this->info('TypoTolerance is already configured as desired; no update needed.');
        }

        // --- 2) Ranking rules adjustment ---

        // Put 'sort' first so when user selects "Sort by" (price, best sellers, etc.), that order is applied fully, not as tie-breaker.
        $desiredRankingRules = ['sort', 'words', 'typo', 'proximity', 'attribute', 'exactness'];
        $originalRanking = $settings['rankingRules'] ?? null;
        $currentRules = is_array($originalRanking) ? $originalRanking : [];

        $this->line('');
        $this->info('Current rankingRules:');
        $this->line(json_encode($originalRanking, JSON_PRETTY_PRINT));

        $updatedRanking = $currentRules;
        if ($currentRules !== $desiredRankingRules) {
            $updatedRanking = $desiredRankingRules;
        }

        if ($updatedRanking !== $currentRules) {
            try {
                $index->updateSettings([
                    'rankingRules' => $updatedRanking,
                ]);

                $this->info('');
                $this->info('Updated rankingRules:');
                $this->line(json_encode($updatedRanking, JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                $this->error('Failed to update rankingRules: '.$e->getMessage());
            }
        } else {
            $this->info('rankingRules did not require changes.');
        }

        // --- 3) Searchable & filterable attributes adjustment ---

        $desiredSearchable = [
            'name',
            'product_name_hi',
            'company_part_number',
            'local_part_number',
            'company_part_number_substitute',
            'brand_name',
            'categories',
            'search_keywords',
        ];

        $originalSearchable = $settings['searchableAttributes'] ?? null;

        $this->line('');
        $this->info('Current searchableAttributes:');
        $this->line(json_encode($originalSearchable, JSON_PRETTY_PRINT));

        $updatedSearchable = $desiredSearchable;

        if ($originalSearchable !== $desiredSearchable) {
            try {
                $index->updateSettings([
                    'searchableAttributes' => $updatedSearchable,
                ]);

                $this->info('');
                $this->info('Updated searchableAttributes:');
                $this->line(json_encode($updatedSearchable, JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                $this->error('Failed to update searchableAttributes: '.$e->getMessage());
            }
        } else {
            $this->info('searchableAttributes already match desired configuration.');
        }

        // --- 4) Filterable attributes adjustment ---

        $desiredFilterable = [
            'category_id',
            'category_2_id',
            'category_3_id',
            'category_4_id',
            'stock',
            'price',
        ];

        $originalFilterable = $settings['filterableAttributes'] ?? null;

        $this->line('');
        $this->info('Current filterableAttributes:');
        $this->line(json_encode($originalFilterable, JSON_PRETTY_PRINT));

        $updatedFilterable = $desiredFilterable;

        if ($originalFilterable !== $desiredFilterable) {
            try {
                $index->updateSettings([
                    'filterableAttributes' => $updatedFilterable,
                ]);

                $this->info('');
                $this->info('Updated filterableAttributes:');
                $this->line(json_encode($updatedFilterable, JSON_PRETTY_PRINT));
            } catch (\Throwable $e) {
                $this->error('Failed to update filterableAttributes: '.$e->getMessage());
            }
        } else {
            $this->info('filterableAttributes already match desired configuration.');
        }

        return self::SUCCESS;
    }
}

