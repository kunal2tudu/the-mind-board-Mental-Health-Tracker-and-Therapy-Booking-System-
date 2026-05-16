<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Therapist;

class TherapistSeeder extends Seeder
{
    public function run(): void
    {
        Therapist::truncate();
        
        Therapist::create([
            'name' => 'Dr. Sam',
            'bio' => 'Specializes in untangling the big scribbles. 10 years experience helping people find the clean whiteboard underneath it all.',
            'icon' => 'face',
            'color' => 'bg-primary',
            'text_color' => 'text-on-primary'
        ]);

        Therapist::create([
            'name' => 'Sarah M.',
            'bio' => 'Focuses on anxiety and creative blocks. Firm believer that a messy board is just a sign of a busy mind.',
            'icon' => 'sentiment_satisfied',
            'color' => 'bg-secondary',
            'text_color' => 'text-on-secondary'
        ]);

        Therapist::create([
            'name' => 'Leo',
            'bio' => 'Your guide for everyday stress. Sometimes all you need is someone to hand you the eraser.',
            'icon' => 'psychology',
            'color' => 'bg-tertiary-container',
            'text_color' => 'text-on-tertiary-container'
        ]);
    }
}
