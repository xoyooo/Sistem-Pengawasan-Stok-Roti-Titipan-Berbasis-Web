<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';

    protected $fillable = [
        'name',
        'phone',
        'owner_name',
        'address',
        'join_date',
        'photo',
        'sales_id',
        'latitude',
        'longitude',
    ];

    /**
     * 🚀 Cast otomatis kolom photo agar langsung jadi array saat diakses
     */
    protected $casts = [
        'photo' => 'array',
        'join_date' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * 🔗 Relasi ke user sales
     */
    public function sales()
    {
        return $this->belongsTo(User::class, 'sales_id');
    }
}
?>