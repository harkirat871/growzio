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
            if (!Schema::hasColumn('products', 'company_part_number_substitute')) {
                $table->string('company_part_number_substitute')->nullable()->after('company_part_number');
            }
            if (!Schema::hasColumn('products', 'dlp')) {
                $table->decimal('dlp', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'unit')) {
                $table->string('unit')->nullable()->after('dlp');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'unit')) {
                $table->dropColumn('unit');
            }
            if (Schema::hasColumn('products', 'dlp')) {
                $table->dropColumn('dlp');
            }
            if (Schema::hasColumn('products', 'company_part_number_substitute')) {
                $table->dropColumn('company_part_number_substitute');
            }
            if (Schema::hasColumn('products', 'company_part_number')) {
                $table->dropColumn('company_part_number');
            }
            if (Schema::hasColumn('products', 'local_part_number')) {
                $table->dropColumn('local_part_number');
            }
            if (Schema::hasColumn('products', 'brand_name')) {
                $table->dropColumn('brand_name');
            }
            if (Schema::hasColumn('products', 'product_name_hi')) {
                $table->dropColumn('product_name_hi');
            }
        });
    }
};

