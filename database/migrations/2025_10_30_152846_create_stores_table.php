<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nama toko
            $table->string('phone');         // No HP
            $table->string('owner_name');    // Nama pemilik
            $table->string('address');       // Alamat toko
            $table->date('join_date');       // Tanggal bergabung
            $table->string('photo')->nullable(); // Foto toko (path)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
