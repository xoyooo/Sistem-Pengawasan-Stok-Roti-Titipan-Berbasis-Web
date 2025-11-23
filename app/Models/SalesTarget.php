<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SalesTarget extends Model
{
    protected $fillable = [
        'user_id',
        'bulan',
        'target_bulanan',
        'tercapai',
    ];

    protected $appends = ['sisa_target'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSisaTargetAttribute()
    {
        $tahun = substr($this->bulan, 0, 4);
        $bulan = substr($this->bulan, 5, 2);

        // Total penjualan bulan tersebut
        $totalPenjualan = \App\Models\SisaRoti::where('user_id', $this->user_id)
            ->whereYear('tanggal_pengambilan', $tahun)
            ->whereMonth('tanggal_pengambilan', $bulan)
            ->sum('total_bill');

        return max($this->target_bulanan - $totalPenjualan, 0);
    }
}
