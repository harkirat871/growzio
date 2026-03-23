<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductDeletionService
{
    /**
     * Permanently delete all products and their order items.
     *
     * Note: This mirrors the existing "delete all" behavior:
     * - delete order_items first to avoid FK restrict errors
     * - then delete products
     */
    public function deleteAllProducts(): void
    {
        DB::transaction(function () {
            OrderItem::query()->delete();
            Product::query()->delete();
        });
    }

    /**
     * Permanently delete products assigned to the provided category IDs.
     *
     * "Directly in that category" is interpreted as: any product where at least
     * one of its category slots matches one of the selected category IDs.
     *
     * IMPORTANT: We do NOT include descendant category IDs.
     */
    public function deleteProductsByCategoryIds(array $categoryIds): int
    {
        $categoryIds = array_values(array_unique(array_filter(array_map(
            static fn ($id) => is_numeric($id) ? (int) $id : null,
            $categoryIds
        ))));

        if ($categoryIds === []) {
            return 0;
        }

        $productIdsSubquery = Product::query()
            ->select('id')
            ->where(function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)
                    ->orWhereIn('category_2_id', $categoryIds)
                    ->orWhereIn('category_3_id', $categoryIds)
                    ->orWhereIn('category_4_id', $categoryIds);
            })
            ->toBase();

        return DB::transaction(function () use ($productIdsSubquery) {
            OrderItem::query()
                ->whereIn('product_id', $productIdsSubquery)
                ->delete();

            // Return number of deleted products.
            return Product::query()
                ->whereIn('id', $productIdsSubquery)
                ->delete();
        });
    }
}

