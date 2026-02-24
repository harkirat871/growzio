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
        if (Schema::hasColumn('products', 'description')) {
            Schema::table('products', function (Blueprint $table) {
                // Make description nullable so it isn't required on insert
                $table->text('description')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'description')) {
            Schema::table('products', function (Blueprint $table) {
                // Revert to NOT NULL (no default) if you roll back
                $table->text('description')->nullable(false)->change();
            });
        }
    }
};

