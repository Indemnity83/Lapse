<?php

use App\Models\Lapse;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('lapse:snap', function () {
    $lapses = Lapse::dueForSnapshot()->get();

    $lapses->each(function (Lapse $lapse) {
        $lapse->snapshot();
        $this->info("Snapshot triggered for {$lapse->name}");
    });
})->everyMinute();
