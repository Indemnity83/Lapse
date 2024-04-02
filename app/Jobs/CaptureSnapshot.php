<?php

namespace App\Jobs;

use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
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
            ->usingFileName($this->getFilename())
            ->withCustomProperties(['lapse_id' => $this->lapse->id])
            ->toMediaCollection(config('media.snapshots'));
    }

    protected function getFilename(): string
    {
        $formattedDate = now()->format('Y-m-d-His');
        $ext = $this->parseExtension($this->camera->url);

        return "camera-{$this->camera->id}-{$formattedDate}.$ext";
    }

    protected function parseExtension(string $url): string
    {
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        if ($ext !== '') {
            return $ext;
        }

        $extensions = [
            'image/jpeg' => 'jpeg',
            'image/gif' => 'gif',
            'image/png' => 'png',
        ];

        $type = get_headers($this->camera->url, 1)['Content-Type'];

        // TODO: returns jpeg if nothing else could be found, would likely
        //       result in corrupt files, should handle this better.
        return Arr::get($extensions, $type, 'jpeg');
    }
}
