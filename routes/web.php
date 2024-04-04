<?php

use App\Models\Camera;
use App\Models\Timelapse;
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
    return view('timelapses');
})->name('timelapses.index');

Route::get('timelapse/{timelapse}', function (Timelapse $timelapse) {
    return view('timelapses.show', ['timelapse' => $timelapse]);
})->name('timelapses.show');

Route::get('admin', function () {
    return view('admin');
})->name('admin');
