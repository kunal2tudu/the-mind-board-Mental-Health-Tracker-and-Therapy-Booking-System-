<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Mood extends Model
{
    protected $fillable = ['user_id', 'mood_type', 'notes'];
}
