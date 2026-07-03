<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

     protected $table = 'foods';

    protected $fillable = [
        'name',
        'name_normalized',
        'aliases',
        'category',
        'serving_description',
        'serving_grams',
        'calories',
        'protein',
        'carbs',
        'fat',
        'source',
    ];

    protected $casts = [
        'aliases' => 'array',
        'serving_grams' => 'float',
        'calories' => 'float',
        'protein' => 'float',
        'carbs' => 'float',
        'fat' => 'float',
    ];
}
