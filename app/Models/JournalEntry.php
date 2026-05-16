<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = ['user_id', 'content'];
}
