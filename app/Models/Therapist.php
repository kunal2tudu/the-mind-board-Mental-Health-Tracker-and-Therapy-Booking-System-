<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Therapist extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'therapists';

    protected $fillable = [
        'name', 'bio', 'icon', 'color', 'text_color'
    ];
}
