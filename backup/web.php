<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // Mock login logic
})->name('login');

Route::get('/register', function () {
    return view('auth.register'); // Fallback since we don't have this view yet
})->name('register');

Route::post('/logout', function () {
    // Mock logout
})->name('logout');

Route::get('/mood', function () {
    return view('mood.index');
})->name('mood.index');

Route::post('/mood', function () {
    // Mock store
})->name('mood.store');

Route::get('/journal', function () {
    return view('journal.index');
})->name('journal.index');

Route::post('/journal', function () {
    // Mock store
})->name('journal.store');

Route::get('/therapists', function () {
    // For now point to booking index
    return view('booking.index');
})->name('therapists.index');

Route::get('/booking', function () {
    return view('booking.index');
})->name('booking.index');

Route::post('/booking', function () {
    // Mock store
})->name('booking.store');

Route::get('/community', function () {
    return "Community feature coming soon.";
})->name('community.index');
