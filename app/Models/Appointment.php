<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'therapist_id', 'date', 'time', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
