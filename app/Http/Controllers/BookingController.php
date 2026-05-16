<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Therapist;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $therapists = Therapist::all();
        $subscription = auth()->user()->subscription;

        if (!$subscription || $subscription->sessions_remaining <= 0 || $subscription->expires_at < now()) {
            return redirect()->route('subscription.index')->with('status', 'You need an active subscription to book a session.');
        }

        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        // Prevent navigating to the past
        $currentDate = now()->startOfMonth();
        $requestedDate = \Carbon\Carbon::createFromDate($year, $month, 1);

        if ($requestedDate < $currentDate) {
            $month = now()->month;
            $year = now()->year;
            $requestedDate = now()->startOfMonth();
        }

        $nextMonth = $requestedDate->copy()->addMonth();
        $prevMonth = $requestedDate->copy()->subMonth();

        return view('booking.index', compact('therapists', 'month', 'year', 'requestedDate', 'nextMonth', 'prevMonth', 'currentDate'));
    }

    public function getAvailability(Request $request, $therapistId)
    {
        $date = $request->query('date');
        
        if (!$date) return response()->json([]);

        // Standard Working Hours
        $standardSlots = ['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'];
        
        // Find existing appointments for this therapist on this date
        $existingAppointments = Appointment::where('therapist_id', $therapistId)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();

        // Check Daily Capacity Limit (Max 5 per day)
        if ($existingAppointments->count() >= 5) {
            return response()->json([]); // No slots available, reached daily limit
        }

        $bookedTimes = $existingAppointments->pluck('time')->toArray();

        // Filter out booked times
        $availableSlots = array_values(array_filter($standardSlots, function($time) use ($bookedTimes) {
            return !in_array($time, $bookedTimes);
        }));

        return response()->json($availableSlots);
    }

    public function store(Request $request)
    {
        $request->validate([
            'therapist_id' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);

        $user = auth()->user();
        $subscription = $user->subscription;

        // 1. Subscription Check
        if (!$subscription || $subscription->sessions_remaining <= 0 || $subscription->expires_at < now()) {
            return redirect()->route('subscription.index')->withErrors(['error' => 'You need an active subscription to book.']);
        }

        // 2. Double Booking Check
        $exists = Appointment::where('therapist_id', $request->therapist_id)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Oops, someone just snagged this slot! Try another time.']);
        }

        // 3. Daily Capacity Check
        $dailyCount = Appointment::where('therapist_id', $request->therapist_id)
            ->where('date', $request->date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
            
        if ($dailyCount >= 5) {
            return back()->withErrors(['error' => 'This therapist is fully booked for this day.']);
        }

        // Save Appointment
        Appointment::create([
            'user_id' => $user->id,
            'therapist_id' => $request->therapist_id,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending' // new status field
        ]);

        // Deduct 1 credit
        $subscription->decrement('sessions_remaining');

        return redirect()->route('dashboard')->with('status', 'Session booked! You have ' . $subscription->sessions_remaining . ' sessions left.');
    }
}
