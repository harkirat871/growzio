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
        Schema::table('products', function (Blueprint $table) {
            // Make image field nullable and rename to image_path
            $table->string('image_path')->nullable()->after('image');
            
            // Add user_id and category_id columns
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            
            // Set default stock to 0
            $table->integer('stock')->default(0)->change();
            
            // Copy data from old image column to image_path
            DB::statement("UPDATE products SET image_path = CONCAT('products/', image)");
        });
        
        // Remove the old image column
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add back the old image column
            $table->string('image')->after('image_path');
            
            // Copy data back from image_path to image
            DB::statement("UPDATE products SET image = SUBSTRING_INDEX(image_path, '/', -1)");
            
            // Drop the foreign keys and columns
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn(['image_path', 'user_id', 'category_id']);
            
            // Revert stock to not have default
            $table->integer('stock')->default(null)->change();
        });
    }
};
