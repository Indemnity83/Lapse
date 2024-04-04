<?php

namespace App\Livewire\Cameras;

use App\Actions\Cameras\CreateCamera;
use App\Models\Camera;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class CameraManager extends Component
{
    public Collection $cameras;

    public $state;

    public bool $previewingCamera = false;

    public ?Camera $cameraBeingPreviewed;

    public function mount(): void
    {
        $this->cameras = Camera::all();

        $this->state = [
            'name' => '',
            'url' => '',
        ];
    }

    public function addCamera(CreateCamera $createCamera): void
    {
        $this->resetErrorBag();

        $createCamera->handle($this->state);

        $this->state = [
            'name' => '',
            'url' => '',
        ];

        $this->cameras = Camera::all();

        $this->dispatch('saved');
    }

    public function previewCamera($cameraId): void
    {
        $this->previewingCamera = true;

        $this->cameraBeingPreviewed = Camera::findOrFail($cameraId);
    }

    public function render(): View
    {
        return view('cameras.camera-manager');
    }
}
