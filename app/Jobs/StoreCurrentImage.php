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

class StoreCurrentImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Camera $camera,
        public ?Lapse $lapse
    ) {
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function handle(): void
    {
        $formattedDate = now()->format('Y-m-d-His');
        $name = "camera-{$this->camera->id}-{$formattedDate}";

        $snapshot = $this->camera
            ->addMediaFromUrl($this->camera->url)
            ->usingName($name)
            ->toMediaCollection(config('media.snapshots'));

        if ($this->lapse) {
            $snapshot
                ->setCustomProperty('lapse_id', $this->lapse->id)
                ->save();
        }

    }
}
