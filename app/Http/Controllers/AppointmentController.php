<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);

        // Ensure user owns it
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        // Refund the session credit if it was pending or confirmed
        if (in_array($appointment->status, ['pending', 'confirmed'])) {
            $subscription = auth()->user()->subscription;
            if ($subscription) {
                $subscription->increment('sessions_remaining');
            }
        }

        $appointment->status = 'cancelled';
        $appointment->save();

        return redirect()->route('dashboard')->with('status', 'Session cancelled. 1 session credit has been refunded to your account.');
    }
}
