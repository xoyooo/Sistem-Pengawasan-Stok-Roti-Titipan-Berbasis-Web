<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name', 'phone', 'owner_name', 'address', 
        'join_date', 'photo', 'sales_id', 
        'latitude', 'longitude'
    ];
}

?>
