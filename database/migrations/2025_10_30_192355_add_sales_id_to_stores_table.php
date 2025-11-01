<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasinya.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada agar aman
            if (!Schema::hasColumn('stores', 'sales_id')) {
                $table->unsignedBigInteger('sales_id')->nullable()->after('photo');
                $table->foreign('sales_id')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Rollback migrasi (hapus perubahan).
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'sales_id')) {
                $table->dropForeign(['sales_id']);
                $table->dropColumn('sales_id');
            }
        });
    }
};
