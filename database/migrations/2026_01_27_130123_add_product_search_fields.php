<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

    Schema::table('products', function (Blueprint $table) {
        $table->string('search_keywords')->nullable()->after('name');
    });    Schema::table('products', function (Blueprint $table) {
        // Check if columns don't exist before adding
        if (!Schema::hasColumn('products', 'product_name_hi')) {
            $table->string('product_name_hi')->nullable()->after('name');
        }
        if (!Schema::hasColumn('products', 'brand_name')) {
            $table->string('brand_name')->nullable()->after('product_name_hi');
        }
        if (!Schema::hasColumn('products', 'local_part_number')) {
            $table->string('local_part_number')->nullable()->after('brand_name');
        }
        if (!Schema::hasColumn('products', 'company_part_number')) {
            $table->string('company_part_number')->nullable()->after('local_part_number');
        }
        if (!Schema::hasColumn('products', 'company_substitute_part_number')) {
            $table->string('company_substitute_part_number')->nullable()->after('company_part_number');
        }
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
