<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoView extends Model
{
    protected $table = 'eventos_views';

    use HasFactory;
    protected $fillable = [
        'evento_id',
        'info',
    ];

    protected $casts = [
        'info' => 'json',
    ];
}
