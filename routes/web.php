<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SubscriptionController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/chat/ask', [ChatController::class, 'ask'])->name('chat.ask');

    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscription.store');

    Route::get('/api/availability/{therapistId}', [\App\Http\Controllers\BookingController::class, 'getAvailability']);

    Route::delete('/appointments/{appointment}', [\App\Http\Controllers\AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

    Route::get('/therapist/dashboard', [\App\Http\Controllers\TherapistDashboardController::class, 'index'])->name('therapist.dashboard');
    Route::post('/therapist/reply', [\App\Http\Controllers\TherapistDashboardController::class, 'reply'])->name('therapist.reply');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mood', [MoodController::class, 'index'])->name('mood.index');
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');

    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    
    // Alias therapists to booking
    Route::get('/therapists', [BookingController::class, 'index'])->name('therapists.index');
    
    Route::get('/community', function () {
        return "Community feature coming soon.";
    })->name('community.index');
});

require __DIR__.'/auth.php';
