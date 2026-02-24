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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('slug')->constrained('categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('categories', 'path')) {
                $table->string('path')->nullable()->after('parent_id')->index();
            }
            if (!Schema::hasColumn('categories', 'depth')) {
                $table->integer('depth')->default(0)->after('path');
            }
            if (!Schema::hasColumn('categories', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('depth');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('categories', 'depth')) {
                $table->dropColumn('depth');
            }
            if (Schema::hasColumn('categories', 'path')) {
                $table->dropColumn('path');
            }
            if (Schema::hasColumn('categories', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            if (Schema::hasColumn('categories', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
