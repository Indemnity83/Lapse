<?php

namespace App\Livewire\Lapses;

use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Support\Collection;
use Livewire\Component;

class CameraForm extends Component
{
    public Lapse $lapse;

    public Collection $cameras;

    public function mount(Lapse $lapse): void
    {
        $this->lapse = $lapse;

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

    public function render()
    {
        return view('lapses.camera-form');
    }
}
