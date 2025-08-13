<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('mail', function () {
        return Inertia::render('mail/Example');
    });
});
