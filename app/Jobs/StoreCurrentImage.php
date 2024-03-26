<?php

namespace App\Jobs;

use App\Models\Camera;
use App\Models\Lapse;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreCurrentImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Camera $camera,
        public ?Lapse $lapse
    ) {
    }

    public function handle(): void
    {
        try {
            $snapshot = $this->camera->createSnapshot();
            $this->lapse?->snapshots()->save($snapshot);
        } catch (Exception $exception) {
            Log::error($exception);
            $this->release(5);
        }
    }
}
