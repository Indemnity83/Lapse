<?php

use App\Models\Timelapse;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('timelapse:run', function () {
    $timelapses = Timelapse::dueForSnapshot()->get();

    $timelapses->each(function (Timelapse $timelapse) {
        \App\Actions\Timelapses\QueueSnapshots::run($timelapse);
        $this->info("Snapshots queued for {$timelapse->name}");
    });
})->everyMinute();
