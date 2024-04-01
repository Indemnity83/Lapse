<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('camera', function () {
        return view('cameras');
    })->name('cameras.index');

    Route::get('camera/{camera}', function (\App\Models\Camera $camera) {
        return view('cameras.show', ['camera' => $camera]);
    })->name('cameras.show');

    Route::get('timelapse', function () {
        return view('lapses');
    })->name('lapses.index');

    Route::get('timelapse/{lapse}', function (\App\Models\Lapse $lapse) {
        return view('lapses.show', ['lapse' => $lapse]);
    })->name('lapses.show');

    Route::get('admin', function () {
        return view('admin');
    })->name('admin');
});
