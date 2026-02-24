<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasCategories = Schema::hasTable('categories');

        Schema::table('products', function (Blueprint $table) use ($hasCategories) {
            // Make image field nullable and rename to image_path (only if not present)
            if (!Schema::hasColumn('products', 'image_path')) {
                $table->string('image_path')->nullable()->after('image');
            }
            
            // Add user_id column
            if (!Schema::hasColumn('products', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            }

            // Add category_id column with FK only if categories table exists
            if (!Schema::hasColumn('products', 'category_id')) {
                if ($hasCategories) {
                    $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
                } else {
                    $table->unsignedBigInteger('category_id')->nullable();
                }
            }
            
            // Set default stock to 0 if column exists and no default (best-effort)
            if (Schema::hasColumn('products', 'stock')) {
                try { $table->integer('stock')->default(0)->change(); } catch (\Throwable $e) {}
            }
        });
        
        // Copy data from old image column to image_path if both exist
        if (Schema::hasColumn('products', 'image') && Schema::hasColumn('products', 'image_path')) {
            try { DB::statement("UPDATE products SET image_path = COALESCE(image_path, CONCAT('products/', image)) WHERE image IS NOT NULL"); } catch (\Throwable $e) {}
        }
        
        // Remove the old image column if exists
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'image')) {
                $table->dropColumn('image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add back the old image column if missing
            if (!Schema::hasColumn('products', 'image') && Schema::hasColumn('products', 'image_path')) {
                $table->string('image')->after('image_path');
            }
            
            // Copy data back from image_path to image
            try { DB::statement("UPDATE products SET image = SUBSTRING_INDEX(image_path, '/', -1) WHERE image_path IS NOT NULL"); } catch (\Throwable $e) {}
            
            // Drop the foreign keys and columns if exist
            if (Schema::hasColumn('products', 'user_id')) {
                try { $table->dropForeign(['user_id']); } catch (\Throwable $e) {}
                $table->dropColumn(['user_id']);
            }
            if (Schema::hasColumn('products', 'category_id')) {
                try { $table->dropForeign(['category_id']); } catch (\Throwable $e) {}
                $table->dropColumn(['category_id']);
            }
            if (Schema::hasColumn('products', 'image_path')) {
                $table->dropColumn(['image_path']);
            }
            
            // Revert stock default best-effort
            if (Schema::hasColumn('products', 'stock')) {
                try { $table->integer('stock')->default(null)->change(); } catch (\Throwable $e) {}
            }
        });
    }
};
