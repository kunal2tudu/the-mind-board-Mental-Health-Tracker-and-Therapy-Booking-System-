<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Therapist;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $subscription = $user->subscription;
        
        // Fetch aggregated data
        $moods = $user->moods()->latest()->take(7)->get();
        $journals = $user->journalEntries()->latest()->take(10)->get();
        
        // Fetch appointments and explicitly pull related Therapist info
        $appointments = $user->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        $therapists = Therapist::all()->keyBy('id');
        
        // Fetch messages
        $messages = \App\Models\Message::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('moods', 'journals', 'appointments', 'therapists', 'subscription', 'messages'));
    }
}
