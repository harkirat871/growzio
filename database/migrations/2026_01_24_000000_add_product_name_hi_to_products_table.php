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
        if (!Schema::hasColumn('products', 'product_name_hi')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('product_name_hi')->nullable()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'product_name_hi')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('product_name_hi');
            });
        }
    }
};

