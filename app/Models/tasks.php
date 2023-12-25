<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    protected $fillable = [
        'name',
        'minutes',
    ];
    use HasFactory;
}
