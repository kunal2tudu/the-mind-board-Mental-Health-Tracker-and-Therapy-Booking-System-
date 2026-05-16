<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'therapist_id' => 'required',
            'body' => 'required|string|max:1000'
        ]);

        $user = auth()->user();

        // Save Message to DB
        $message = Message::create([
            'user_id' => $user->id,
            'therapist_id' => $request->therapist_id,
            'sender_type' => 'user', // user or therapist
            'body' => $request->body,
            'read' => false
        ]);

        // Attempt to send email to the therapist (mocked as user's request)
        $therapistEmail = 'kunaltudu2@gmail.com'; 
        
        try {
            Mail::raw("You have a new message from Patient: {$user->name}.\n\nMessage: {$request->body}\n\nPlease log in to the Therapist Dashboard to reply.", function ($mail) use ($therapistEmail) {
                $mail->to($therapistEmail)
                     ->subject('New Patient Message - The Mind Board');
            });
        } catch (\Exception $e) {
            // Silently fail if SMTP is not configured locally, but message is still saved in DB
            \Log::error('Mail failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('status', 'Message sent successfully to your therapist!');
    }
}
