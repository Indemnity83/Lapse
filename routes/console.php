<?php

use App\Models\Lapse;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('timelapse:run', function () {
    $lapses = Lapse::dueForSnapshot()->get();

    $lapses->each(function (Lapse $lapse) {
        \App\Actions\Timelapses\QueueSnapshots::run($lapse);
        $this->info("Snapshots queued for {$lapse->name}");
    });
})->everyMinute();
