<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhysiquePhoto extends Model
{
    protected $fillable = ['user_id', 'photo', 'notes', 'date', 'timestamp'];
}
