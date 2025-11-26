<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyViews1 extends Model
{
    use HasFactory;
    protected $table ='monthly_views1';

    use HasFactory;

    protected $fillable = [
        'dateAdded',
    ];
}
