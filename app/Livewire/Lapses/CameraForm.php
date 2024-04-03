<?php

namespace App\Livewire\Lapses;

use App\Jobs\GenerateVideo;
use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\MediaLibrary\Support\MediaStream;

class CameraForm extends Component
{
    public Lapse $lapse;

    public Collection $cameras;

    public Collection $camerasWithSnapshots;

    public function mount(Lapse $lapse): void
    {
        $this->lapse = $lapse;
        $this->camerasWithSnapshots = Camera::query()->whereHas('media', function ($query) {
            $query
                ->where('collection_name', config('media.snapshots'))
                ->where('custom_properties->lapse_id', $this->lapse->id);
        })->get();

        $this->cameras = Camera::all()->map(fn (Camera $camera) => [
            'id' => $camera->id,
            'name' => $camera->name,
            'enabled' => $lapse->cameras->contains('id', $camera->id),
        ]);
    }

    public function toggleCamera($cameraId): void
    {
        $this->cameras = $this->cameras->map(function ($camera) use ($cameraId) {
            if ($camera['id'] == $cameraId) {
                $camera['enabled'] = ! $camera['enabled'];

                if ($camera['enabled']) {
                    $this->lapse->cameras()->attach($cameraId);
                } else {
                    $this->lapse->cameras()->detach($cameraId);
                }
            }

            return $camera;
        });
    }

    public function download($cameraId)
    {
        $snapshots = Camera::findOrFail($cameraId)->snapshotsFor($this->lapse);

        return MediaStream::create('snapshots.zip')->addMedia($snapshots);
    }

    public function video($cameraId)
    {
        // TODO: let user know things are working, cache some key for being rendered
        //       that will be cleared when the job is done
        $camera = Camera::findOrFail($cameraId);
        GenerateVideo::dispatch($this->lapse, $camera);
    }

    public function render()
    {
        return view('lapses.camera-form');
    }
}
