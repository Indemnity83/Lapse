<?php

namespace App\Jobs;

use App\Models\Camera;
use App\Models\Timelapse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class GenerateVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Timelapse $timelapse,
        public Camera $camera,
        public int $framerate = 4
    ) {
    }

    /**
     * @throws FileCannotBeAdded
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function handle(): void
    {
        $output = tempnam(sys_get_temp_dir(), 'ffmpeg') . '.mp4';
        $pattern = storage_path("app/public/timelapse-{$this->timelapse->id}/camera-{$this->camera->id}-*.jpeg");

        shell_exec("ffmpeg -framerate {$this->framerate} -pattern_type glob -i \"{$pattern}\" {$output} 2>&1");

        $media = $this->timelapse
            ->addMedia($output)
            ->usingName($this->getFilename())
            ->usingFileName($this->getFilename())
            ->toMediaCollection('timelapse')
            ->save();
    }

    protected function getFilename(): string
    {
        $formattedDate = now()->format('Y-m-d-His');

        return "{$this->camera->name} ({$formattedDate}).mp4";
    }
}
