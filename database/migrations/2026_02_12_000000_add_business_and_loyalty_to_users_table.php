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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable()->after('name');
            $table->string('contact_number', 20)->nullable()->after('business_name');
            $table->string('referred_by')->nullable()->after('contact_number');
            $table->unsignedInteger('loyalty_points')->default(0)->after('referred_by');

            $table->index('contact_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['contact_number']);
            $table->dropColumn(['business_name', 'contact_number', 'referred_by', 'loyalty_points']);
        });
    }
};
