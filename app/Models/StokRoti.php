<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokRoti extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama_toko', 'jumlah_roti', 'jumlah_sisa',
        'tanggal_pengantaran', 'foto_roti', 'foto_sisa'
    ];


    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
