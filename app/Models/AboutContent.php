<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasFactory;
    protected $fillable = [
        'video',
        'somos',
        'missao',
        'visao',
        'valores',
        'orgaos_singulares',
        'orgaos_colegiais',
        'administracao',
        'historial',
        'organigrama',
        'regulamentos'
    ];

    protected $casts = [
        'valores' => 'json',
        'orgaos_singulares' => 'json',
        'orgaos_colegiais' => 'json',  // Cast the field to JSON,
        'administracao' => 'json',
        'historial' => 'json',
        'regulamentos' => 'json',

    ];

    protected $attributes = [
        'video' => null,
    ];
}
