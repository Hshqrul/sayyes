<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::get('inbox', function () {
        return Inertia::render('mail/Example');
    });
});
