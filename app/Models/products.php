<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = [
        'image',
        'barcode',
        'product_name',
        'product_quantity',
        'unit',
        'product_price',
        'supplier',
        'isAvailable',
    ];
    use HasFactory;
}
