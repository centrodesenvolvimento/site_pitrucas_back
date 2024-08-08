<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'imagens',
        'info',

    ];

    protected $casts = [
        'imagens' => 'json', // Cast the field to JSON
        'info' => 'json', // Cast the field to JSON

    ];

}
