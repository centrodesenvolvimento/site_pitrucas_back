<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    use HasFactory;
    protected $fillable = [
        'info',
        'cursos',
    ];

    protected $casts = [
        'info' => 'json',
        'cursos' => 'json',


    ];


}
