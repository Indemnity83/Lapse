<?php

namespace App\Livewire\Timelapses;

use App\Models\Camera;
use App\Models\Timelapse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class TimelapseManager extends Component
{
    public Collection $timelapses;

    public Collection $cameras;

    public array $addTimelapseForm = [
        'name' => '',
        'interval' => 5,
    ];

    public $timelapseCameras = [];

    protected $listeners = [
        'cameraAdded',
    ];

    public function mount(): void
    {
        $this->resetFormData();
    }

    public function cameraAdded(): void
    {
        $this->cameras = Camera::all()->map(fn (Camera $camera) => [
            'id' => $camera->id,
            'name' => $camera->name,
            'enabled' => false,
        ]);
    }

    public function toggleCamera($cameraId): void
    {
        $this->cameras = $this->cameras->map(function ($camera) use ($cameraId) {
            if ($camera['id'] == $cameraId) {
                $camera['enabled'] = ! $camera['enabled'];
            }

            return $camera;
        });
    }

    public function addTimelapse(): void
    {
        $this->resetErrorBag();

        $timelapse = Timelapse::create([
            'name' => $this->addTimelapseForm['name'],
            'interval' => $this->addTimelapseForm['interval'],
            'is_paused' => true,
        ]);

        $timelapse->cameras()->attach($this->cameras
            ->where(fn ($camera) => $camera['enabled'] === true)
            ->pluck('id'));

        $this->addTimelapseForm = [
            'name' => '',
            'interval' => 5,
        ];

        $this->cameras = $this->cameras->map(function ($camera) {
            $camera['enabled'] = false;

            return $camera;
        });

        $this->timelapses = Timelapse::all();

        $this->dispatch('saved');
    }

    public function resetFormData(): void
    {
        $this->timelapses = Timelapse::all();
        $this->cameras = Camera::all()->map(fn (Camera $camera) => [
            'id' => $camera->id,
            'name' => $camera->name,
            'enabled' => false,
        ]);
    }

    public function render(): View
    {
        return view('timelapses.timelapse-manager');
    }
}
