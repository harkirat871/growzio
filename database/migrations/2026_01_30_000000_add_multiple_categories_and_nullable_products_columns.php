<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * - Adds category_2_id, category_3_id, category_4_id (nullable, FK, ON DELETE SET NULL).
     * - Ensures category_id is NOT NULL (backfill existing NULLs with first category).
     * - Makes all columns nullable except category_id, name, company_part_number.
     */
    public function up(): void
    {
        $this->addCategoryColumns();
        $this->backfillAndEnforceRequiredColumns();
        $this->makeNullableColumnsExceptRequired();
    }

    /**
     * Add category_2_id, category_3_id, category_4_id with foreign keys (ON DELETE SET NULL).
     */
    protected function addCategoryColumns(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'category_2_id')) {
                $table->unsignedBigInteger('category_2_id')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('products', 'category_3_id')) {
                $table->unsignedBigInteger('category_3_id')->nullable()->after('category_2_id');
            }
            if (!Schema::hasColumn('products', 'category_4_id')) {
                $table->unsignedBigInteger('category_4_id')->nullable()->after('category_3_id');
            }
        });

        if (Schema::hasTable('categories')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'category_2_id')) {
                    try {
                        $table->foreign('category_2_id')->references('id')->on('categories')->nullOnDelete();
                    } catch (\Throwable $e) {
                        // FK may already exist
                    }
                }
                if (Schema::hasColumn('products', 'category_3_id')) {
                    try {
                        $table->foreign('category_3_id')->references('id')->on('categories')->nullOnDelete();
                    } catch (\Throwable $e) {
                    }
                }
                if (Schema::hasColumn('products', 'category_4_id')) {
                    try {
                        $table->foreign('category_4_id')->references('id')->on('categories')->nullOnDelete();
                    } catch (\Throwable $e) {
                    }
                }
            });
        }
    }

    /**
     * Backfill NULL category_id / company_part_number and enforce NOT NULL where required.
     */
    protected function backfillAndEnforceRequiredColumns(): void
    {
        if (Schema::hasTable('categories')) {
            $firstId = DB::table('categories')->value('id');
            if ($firstId !== null) {
                DB::table('products')->whereNull('category_id')->update(['category_id' => $firstId]);
            }
        }

        DB::table('products')->whereNull('company_part_number')->orWhere('company_part_number', '')->update([
            'company_part_number' => DB::raw("COALESCE(NULLIF(TRIM(company_part_number), ''), CONCAT('LEGACY-', id))"),
        ]);

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY COLUMN category_id BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE products MODIFY COLUMN company_part_number VARCHAR(255) NOT NULL');
        }
    }

    /**
     * Make all columns nullable except category_id, name, company_part_number.
     */
    protected function makeNullableColumnsExceptRequired(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            $nullableColumns = [
                'description' => 'TEXT NULL',
                'price' => 'DECIMAL(10,2) NULL',
                'stock' => 'INT NULL',
                'image_path' => 'VARCHAR(255) NULL',
                'user_id' => 'BIGINT UNSIGNED NULL',
                'product_name_hi' => 'VARCHAR(255) NULL',
                'brand_name' => 'VARCHAR(255) NULL',
                'local_part_number' => 'VARCHAR(255) NULL',
                'company_part_number_substitute' => 'VARCHAR(255) NULL',
                'dlp' => 'DECIMAL(10,2) NULL',
                'unit' => 'VARCHAR(255) NULL',
                'search_keywords' => 'VARCHAR(255) NULL',
            ];
            foreach ($nullableColumns as $col => $def) {
                if (Schema::hasColumn('products', $col)) {
                    try {
                        DB::statement("ALTER TABLE products MODIFY COLUMN `{$col}` {$def}");
                    } catch (\Throwable $e) {
                        // Column may already be nullable
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category_4_id')) {
                $table->dropForeign(['category_4_id']);
                $table->dropColumn('category_4_id');
            }
            if (Schema::hasColumn('products', 'category_3_id')) {
                $table->dropForeign(['category_3_id']);
                $table->dropColumn('category_3_id');
            }
            if (Schema::hasColumn('products', 'category_2_id')) {
                $table->dropForeign(['category_2_id']);
                $table->dropColumn('category_2_id');
            }
        });

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE products MODIFY COLUMN category_id BIGINT UNSIGNED NULL');
            DB::statement('ALTER TABLE products MODIFY COLUMN company_part_number VARCHAR(255) NULL');
            $revert = [
                'description' => 'TEXT NOT NULL',
                'price' => 'DECIMAL(10,2) NOT NULL',
                'stock' => 'INT NOT NULL',
            ];
            foreach ($revert as $col => $def) {
                if (Schema::hasColumn('products', $col)) {
                    try {
                        DB::statement("ALTER TABLE products MODIFY COLUMN `{$col}` {$def}");
                    } catch (\Throwable $e) {
                    }
                }
            }
        }
    }
};
