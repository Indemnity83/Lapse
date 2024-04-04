<?php

namespace App\Livewire\Timelapses;

use App\Jobs\GenerateVideo;
use App\Models\Camera;
use App\Models\Timelapse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\MediaLibrary\Support\MediaStream;

class CameraForm extends Component
{
    public Timelapse $timelapse;

    public Collection $camerasWithSnapshots;

    public function mount(Timelapse $timelapse): void
    {
        $this->timelapse = $timelapse;
        $this->camerasWithSnapshots = Camera::query()->whereHas('media', function ($query) {
            $query
                ->where('collection_name', config('media.snapshots'))
                ->where('custom_properties->timelapse_id', $this->timelapse->id);
        })->get();
    }

    public function download($cameraId)
    {
        $snapshots = Camera::findOrFail($cameraId)->snapshotsFor($this->timelapse);

        return MediaStream::create('snapshots.zip')->addMedia($snapshots);
    }

    public function video($cameraId)
    {
        // TODO: let user know things are working, cache some key for being rendered
        //       that will be cleared when the job is done
        $camera = Camera::findOrFail($cameraId);
        GenerateVideo::dispatch($this->timelapse, $camera);
    }

    public function render()
    {
        return view('timelapses.camera-form');
    }
}
