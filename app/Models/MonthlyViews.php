<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyViews extends Model
{

    protected $table ='monthly_views';

    use HasFactory;

    protected $fillable = [
        'dateAdded',
    ];
}
