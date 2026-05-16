<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscription = auth()->user()->subscription;
        return view('subscription.index', compact('subscription'));
    }

    public function store(Request $request)
    {
        // Mock payment process - Instantly grant subscription
        $user = auth()->user();
        
        Subscription::updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => 'active',
                'expires_at' => Carbon::now()->addDays(30),
                'sessions_remaining' => 4 // Grant 4 sessions
            ]
        );

        return redirect()->route('dashboard')->with('status', 'Subscription active! You have 4 sessions available.');
    }
}
