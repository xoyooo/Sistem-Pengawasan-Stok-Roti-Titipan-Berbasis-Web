<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokRotiVariansTable extends Migration
{
    public function up()
    {
        Schema::create('stok_roti_varians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_roti_id')->constrained('stok_rotis')->onDelete('cascade');
            $table->string('nama_varian');
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stok_roti_varians');
    }
}
