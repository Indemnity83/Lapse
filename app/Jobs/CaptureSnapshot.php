<?php

namespace App\Jobs;

use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CaptureSnapshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Camera $camera,
        public Lapse $lapse
    ) {
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function handle(): void
    {
        $this->camera
            ->addMediaFromUrl($this->camera->url)
            ->usingName($this->getFilename())
            ->toMediaCollection(config('media.snapshots'))
            ->setCustomProperty('lapse_id', $this->lapse->id)
            ->save();
    }

    protected function getFilename(): string
    {
        $formattedDate = now()->format('Y-m-d-His');

        return "camera-{$this->camera->id}-{$formattedDate}";
    }
}
