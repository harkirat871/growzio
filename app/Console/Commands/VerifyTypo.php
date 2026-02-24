<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Meilisearch\Client as MeilisearchClient;

class VerifyTypo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meilisearch:verify-typo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify whether Meilisearch typo tolerance is active on the Product index';

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

        // Resolve Product index name dynamically using searchableAs()
        try {
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

        $this->info('Meilisearch host: '.$host);
        $this->info('Product index name: '.$indexName);

        try {
            $client = new MeilisearchClient($host, $key);
            $index = $client->index($indexName);
        } catch (\Throwable $e) {
            $this->error('Failed to connect to Meilisearch or fetch index: '.$e->getMessage());

            return self::FAILURE;
        }

        // Fetch full settings for inspection
        try {
            $settings = (array) $index->getSettings();
        } catch (\Throwable $e) {
            $this->error('Failed to fetch Meilisearch settings: '.$e->getMessage());

            return self::FAILURE;
        }

        $typoBlock = $settings['typoTolerance'] ?? null;
        $rankingRules = $settings['rankingRules'] ?? null;

        $this->line('');
        $this->info('typoTolerance:');
        $this->line(json_encode($typoBlock, JSON_PRETTY_PRINT));

        $this->line('');
        $this->info('rankingRules:');
        $this->line(json_encode($rankingRules, JSON_PRETTY_PRINT));

        // Raw Meilisearch searches to verify typo behavior
        $queries = ['test', 'tess', 'tesx', 'tset'];

        foreach ($queries as $query) {
            try {
                $this->line('');
                $this->info("Raw Meilisearch search for query: '{$query}'");
                $result = $index->search($query);
                $hits = $result->getHits();
                $hitsCount = is_array($hits) ? count($hits) : 0;

                $this->info("Raw Meilisearch hits count: {$hitsCount}");

                if ($hitsCount > 0) {
                    $first = $hits[0];
                    $name = is_array($first) && array_key_exists('name', $first)
                        ? $first['name']
                        : null;

                    if ($name !== null) {
                        $this->info('First hit name: '.$name);
                    } else {
                        $this->info('First hit (raw):');
                        $this->line(json_encode($first, JSON_PRETTY_PRINT));
                    }
                }
            } catch (\Throwable $e) {
                $this->error("Failed raw search for '{$query}': ".$e->getMessage());
            }

            // Scout search comparison for the same query
            try {
                $this->line('');
                $this->info("Scout search for query: '{$query}'");
                $scoutResult = \App\Models\Product::search($query)->raw();
                $scoutHits = isset($scoutResult['hits']) && is_array($scoutResult['hits'])
                    ? $scoutResult['hits']
                    : [];
                $scoutHitsCount = is_array($scoutHits) ? count($scoutHits) : 0;

                $this->info("Scout hits count: {$scoutHitsCount}");

                if ($scoutHitsCount > 0) {
                    $firstScout = $scoutHits[0];
                    $scoutName = is_array($firstScout) && array_key_exists('name', $firstScout)
                        ? $firstScout['name']
                        : null;

                    if ($scoutName !== null) {
                        $this->info('First Scout hit name: '.$scoutName);
                    } else {
                        $this->info('First Scout hit (raw):');
                        $this->line(json_encode($firstScout, JSON_PRETTY_PRINT));
                    }
                }
            } catch (\Throwable $e) {
                $this->error("Failed Scout search for '{$query}': ".$e->getMessage());
            }
        }

        return self::SUCCESS;
    }
}

