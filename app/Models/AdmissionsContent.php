<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionsContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'emolumentos',
        'calendario',
        'exames',
        'perguntas'
    ];

    protected $casts = [
        'exames' => 'json',
        'perguntas' => 'json',

    ];
}
