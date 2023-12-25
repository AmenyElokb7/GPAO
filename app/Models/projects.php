<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    protected $fillable = [
        'name',
        'tasks',
        'start_date',
        'delivery_date',
        'products',
        'status',
    ];
    use HasFactory;
}
?>