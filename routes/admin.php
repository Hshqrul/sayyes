<?php

use App\Http\Controllers\InboxController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('inbox', function () {
        return Inertia::render('mail/Example');
    });

    Route::get('/note', [InboxController::class, 'index'])
        ->name('mail.index');
    Route::post('/mail/store', [InboxController::class, 'store'])->name('note.store');
    Route::delete('/mail/{message}', [InboxController::class, 'destroy'])->name('note.destroy');
    Route::post('/mail/{id}/read', [InboxController::class, 'markAsRead'])->name('note.read');
    Route::post('/mail/{id}/unread', [InboxController::class, 'markAsUnread'])->name('note.unread');
});
