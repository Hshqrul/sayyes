<?php

use App\Http\Controllers\InboxController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('inbox', function () {
        return Inertia::render('mail/Example');
    });

    Route::get('/mail', [InboxController::class, 'index'])
        ->name('mail.index');
    Route::post('/mail/store', [InboxController::class, 'store'])->name('mail.store');
    Route::delete('/mail/{message}', [InboxController::class, 'destroy'])->name('mail.destroy');
    Route::patch('/mail/{id}/read', [InboxController::class, 'markAsRead'])->name('mail.read');
});
