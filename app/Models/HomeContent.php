<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'videoInicial',
        'imagemPr',
        'mensagemPr',
        'testemunhos',
    ];

    protected $casts = [
        'testemunhos' => 'json', // Cast the field to JSON
    ];

    protected $attributes = [
        'videoInicial' => null,
        'imagemPr' => null,
    ];
}
