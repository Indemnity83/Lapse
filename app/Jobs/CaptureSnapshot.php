<?php

namespace App\Jobs;

use App\Exceptions\UnknownExtension;
use App\Models\Camera;
use App\Models\Timelapse;
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
        public Timelapse $timelapse
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
            ->withCustomProperties(['timelapse_id' => $this->timelapse->id])
            ->toMediaCollection(config('media.snapshots'));
    }

    protected function getFilename(): string
    {
        $formattedDate = now()->format('Y-m-d-His');
        $ext = $this->parseExtension($this->camera->url);

        return "camera-{$this->camera->id}-{$formattedDate}.{$ext}";
    }

    /**
     * @throws UnknownExtension
     */
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

        $type = get_headers($this->camera->url, true)['Content-Type'];

        if (Arr::has($extensions, $type)) {
            return Arr::get($extensions, $type);
        }

        throw new UnknownExtension('Cannot determine the file type/extension for the file');
    }
}
