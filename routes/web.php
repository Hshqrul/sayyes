<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Dashboard');
    // return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
// ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('rsvp', [App\Http\Controllers\RsvpController::class, 'create'])->name('rsvp.create');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
