<?php

use App\Http\Controllers\EventController;
use App\Models\Rsvp;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\UserDashboardController;
use App\Models\Event;

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user_dashboard');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit/', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/rsvps', [RsvpController::class, 'index'])->name('rsvps.index');
    Route::delete('/rsvp/{rsvp}', [RsvpController::class, 'destroy'])->name('rsvps.destroy');
});

Route::get('/event/{event}', function (Event $event) {
    return Inertia::render('RsvpPage', [
        'event' => $event,
        'rsvps' => $event->rsvps()->orderBy('created_at', 'desc')->get(),
    ]);
})->name('event_rsvp');

Route::get('/rsvp', [RsvpController::class, 'create'])->name('rsvp.create');
Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::get('/rsvp/success/{name}/{event}', function ($name, $event) {
    $event = Event::where('id', $event)->first();
    $rsvps = Rsvp::where('name', '!=', null)->orderBy('created_at', 'desc')->limit(4)->get();
    $rsvp = Rsvp::where('name', $name)->first();
    return Inertia::render('rsvp/SucceedRsvp', [
        'event' => $event,
        'rsvps' => $rsvps,
        'rsvp' => $rsvp,
    ]);
})->name('rsvp.success');


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
