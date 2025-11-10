<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('stok_rotis', function (Blueprint $table) {
            $table->integer('jumlah_sisa')->nullable()->after('jumlah_roti');
            $table->string('foto_sisa')->nullable()->after('foto_roti');
        });
    }

    public function down(): void {
        Schema::table('stok_rotis', function (Blueprint $table) {
            $table->dropColumn(['jumlah_sisa', 'foto_sisa']);
        });
    }
};

