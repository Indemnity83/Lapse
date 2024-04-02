<?php

namespace App\Livewire\Lapses;

use App\Models\Camera;
use App\Models\Lapse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class LapseManager extends Component
{
    public Collection $lapses;

    public Collection $cameras;

    public array $addLapseForm = [
        'name' => '',
        'interval' => 5,
    ];

    public $lapseCameras = [];

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

    public function addLapse(): void
    {
        $this->resetErrorBag();

        $lapse = Lapse::create([
            'name' => $this->addLapseForm['name'],
            'interval' => $this->addLapseForm['interval'],
            'is_paused' => true,
        ]);

        $lapse->cameras()->attach($this->cameras
            ->where(fn ($camera) => $camera['enabled'] === true)
            ->pluck('id'));

        $this->addLapseForm = [
            'name' => '',
            'interval' => 5,
        ];

        $this->cameras = $this->cameras->map(function ($camera) {
            $camera['enabled'] = false;

            return $camera;
        });

        $this->lapses = Lapse::all();

        $this->dispatch('saved');
    }

    public function resetFormData(): void
    {
        $this->lapses = Lapse::all();
        $this->cameras = Camera::all()->map(fn (Camera $camera) => [
            'id' => $camera->id,
            'name' => $camera->name,
            'enabled' => false,
        ]);
    }

    public function render(): View
    {
        return view('lapses.lapse-manager');
    }
}
