<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Http\Request;

class MoodController extends Controller
{
    public function index()
    {
        $moods = auth()->user()->moods()->latest()->take(7)->get()->reverse()->values();
        
        $tips = [
            "Take a deep breath. You're doing the best you can, and that's enough.",
            "It's okay to take a break. Productivity isn't your only worth.",
            "Drink some water and stretch. Small physical resets help your mind.",
            "Acknowledge one thing you did well today, no matter how small.",
            "Your feelings are valid, even if they're messy right now.",
            "Focus on the present moment. The future hasn't happened yet."
        ];
        $dailyTip = $tips[array_rand($tips)];

        return view('mood.index', compact('moods', 'dailyTip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mood_type' => 'required|in:good,okay,hard',
        ]);

        Mood::create([
            'user_id' => auth()->id(),
            'mood_type' => $request->mood_type,
            'notes' => $request->notes ?? '',
        ]);

        return redirect()->route('mood.index')->with('status', 'Mood logged!');
    }
}
