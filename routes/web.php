<?php

use App\Models\Rsvp;
use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    // return Inertia::render('MockupDashboard');
    return redirect('/dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user_dashboard');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}/update', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/rsvps', [RsvpController::class, 'index'])->name('rsvps.index');
    Route::get('/rsvps/{rsvp}/edit', [RsvpController::class, 'edit'])->name('rsvps.edit');
    Route::put('/rsvps/{rsvp}', [RsvpController::class, 'update'])->name('rsvps.update');
    Route::delete('/rsvp/{rsvp}/destroy', [RsvpController::class, 'destroy'])->name('rsvps.destroy');

    Route::get('/note', [InboxController::class, 'index'])->name('mail.index');
    Route::post('/mail/store', [InboxController::class, 'store'])->name('note.store');
    Route::delete('/mail/{message}', [InboxController::class, 'destroy'])->name('note.destroy');
    Route::post('/mail/{id}/read', [InboxController::class, 'markAsRead'])->name('note.read');
    Route::post('/mail/{id}/unread', [InboxController::class, 'markAsUnread'])->name('note.unread');
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
    $rsvps = $event->rsvps()->where('name', '!=', null)->orderBy('created_at', 'desc')->get();
    $rsvp = Rsvp::where('name', $name)->first();
    return Inertia::render('rsvp/SucceedRsvp', [
        'event' => $event,
        'rsvps' => $rsvps,
        'rsvp' => $rsvp,
    ]);
})->name('rsvp.success');

// Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
// Route::resource('/portfolio', PortfolioController::class);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';