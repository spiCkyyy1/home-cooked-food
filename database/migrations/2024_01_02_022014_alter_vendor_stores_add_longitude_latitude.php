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
        Schema::table('vendor_stores', function (Blueprint $table) {
            $table->double('longitude')->after('address')->nullable()->default(null);
            $table->double('latitude')->after('longitude')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendor_stores', function (Blueprint $table) {
            $table->dropColumn(['longitude', 'latitude']);
        });
    }
};
