<?php

namespace App\Livewire\Dashboard;

use App\Models\Camera;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class CameraManager extends Component
{
    public Collection $cameras;

    public bool $confirmingCameraRemoval = false;

    public ?Camera $cameraBeingRemoved;

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

        Camera::create([
            'name' => $this->addCameraForm['name'],
            'url' => $this->addCameraForm['url'],
        ]);

        $this->addCameraForm = [
            'name' => '',
            'url' => '',
        ];

        $this->cameras = Camera::all();

        $this->dispatch('saved');
    }

    public function confirmCameraRemoval($cameraId): void
    {
        $this->confirmingCameraRemoval = true;

        $this->cameraBeingRemoved = Camera::findOrFail($cameraId);
    }

    public function removeCamera(): void
    {
        $this->cameraBeingRemoved->delete();

        $this->confirmingCameraRemoval = false;

        $this->cameraBeingRemoved = null;

        $this->cameras = Camera::all();
    }

    public function render(): View
    {
        return view('dashboard.camera-manager');
    }
}
