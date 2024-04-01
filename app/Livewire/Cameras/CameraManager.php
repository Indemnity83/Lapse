<?php

namespace App\Livewire\Cameras;

use App\Models\Camera;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class CameraManager extends Component
{
    public Collection $cameras;

    public bool $previewingCamera = false;

    public ?Camera $cameraBeingPreviewed;

    public array $addCameraForm = [
        'name' => '',
        'url' => '',
    ];

    public function mount(): void
    {
        $this->cameras = Camera::all();
    }

    public function addCamera(): void
    {
        $this->resetErrorBag();

        $camera = Camera::create([
            'name' => $this->addCameraForm['name'],
            'url' => $this->addCameraForm['url'],
        ]);

        $this->addCameraForm = [
            'name' => '',
            'url' => '',
        ];

        $this->cameras = Camera::all();

        $this->dispatch('cameraAdded');
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
