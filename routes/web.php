<?php

use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('camera', function () {
    return view('cameras');
})->name('cameras.index');

Route::get('camera/{camera}', function (Camera $camera) {
    return view('cameras.show', ['camera' => $camera]);
})->name('cameras.show');

Route::get('timelapse', function () {
    return view('lapses');
})->name('lapses.index');

Route::get('timelapse/{lapse}', function (Lapse $lapse) {
    return view('lapses.show', ['lapse' => $lapse]);
})->name('lapses.show');

Route::get('admin', function () {
    return view('admin');
})->name('admin');
