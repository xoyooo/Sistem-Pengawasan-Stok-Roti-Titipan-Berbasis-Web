<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokRoti extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'toko_id',
        'jumlah_roti',
        'tanggal_pengantaran',
        'foto_roti',
    ];
}
