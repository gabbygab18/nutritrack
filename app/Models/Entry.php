<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'meal',
        'servings',
        'serving_unit',
        'per_calories',
        'per_protein',
        'per_carbs',
        'per_fat',
        'calories',
        'protein',
        'carbs',
        'fat',
        'photo',
        'date',
        'timestamp',
    ];

    protected $casts = [
        'servings' => 'float',
        'per_calories' => 'float',
        'per_protein' => 'float',
        'per_carbs' => 'float',
        'per_fat' => 'float',
        'calories' => 'float',
        'protein' => 'float',
        'carbs' => 'float',
        'fat' => 'float',
        'date' => 'date:Y-m-d',
        'timestamp' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
