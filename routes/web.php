<?php

use App\Models\Rsvp;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsvpController;

// Route::get('/', function () {
//     return redirect()->route('dashboard');
//     // return Inertia::render('Welcome');
// })->name('home');

Route::get('/', function () {
    // return Inertia::render('Dashboard');
    return Inertia::render('Dashboard');
})->name('dashboard');
// ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('home', function () {
    return Inertia::render('LandingPageRsvp');
})->name('home');

Route::get('/rsvp', [RsvpController::class, 'create'])->name('rsvp.create');
Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::get('/rsvp/success/{name}', function ($name) {
    $rsvps = Rsvp::where('name', '!=', null)->orderBy('created_at', 'desc')->limit(4)->get();
    $rsvp = Rsvp::where('name', $name)->first();
    return Inertia::render('rsvp/SucceedRsvp', [
        'rsvps' => $rsvps,
        'rsvp' => $rsvp,
    ]);
})->name('rsvp.success');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
