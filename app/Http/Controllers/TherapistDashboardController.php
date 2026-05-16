<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Appointment;
use App\Models\User;

class TherapistDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user->is_therapist || !$user->linked_therapist_id) {
            abort(403, 'Unauthorized access.');
        }

        $therapistId = $user->linked_therapist_id;

        // Fetch upcoming appointments for this therapist
        $appointments = Appointment::where('therapist_id', $therapistId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('user')
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        // Fetch messages sent to this therapist
        $messages = Message::where('therapist_id', $therapistId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get unique users who messaged to show their names
        $userIds = $messages->pluck('user_id')->unique();
        $patients = User::whereIn('id', $userIds)->get()->keyBy('id');

        return view('therapist.dashboard', compact('appointments', 'messages', 'patients'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'body' => 'required|string|max:1000'
        ]);

        $user = auth()->user();

        if (!$user->is_therapist || !$user->linked_therapist_id) {
            abort(403);
        }

        Message::create([
            'user_id' => $request->user_id,
            'therapist_id' => $user->linked_therapist_id,
            'sender_type' => 'therapist',
            'body' => $request->body,
            'read' => false
        ]);

        return redirect()->back()->with('status', 'Reply sent to patient!');
    }
}
