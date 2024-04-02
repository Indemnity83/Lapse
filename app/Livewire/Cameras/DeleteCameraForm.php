<?php

namespace App\Livewire\Cameras;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteCameraForm extends Component
{
    public $camera;

    public $confirmingCameraDeletion = false;

    public $name;

    public function mount($camera): void
    {
        $this->camera = $camera;
    }

    public function confirmCameraDeletion(): void
    {
        $this->resetErrorBag();

        $this->name = '';

        $this->dispatch('confirming-delete-camera');

        $this->confirmingCameraDeletion = true;
    }

    public function deleteCamera()
    {
        $this->resetErrorBag();

        if ($this->name !== $this->camera->name) {
            throw ValidationException::withMessages([
                'name' => [__('name does not match.')],
            ]);
        }

        // TODO: move this into an action
        DB::transaction(function () {
            $this->camera->snapshots->each->delete();
            $this->camera->delete();
        });

        return redirect(route('cameras'));
    }

    public function render()
    {
        return view('cameras.delete-camera-form');
    }
}
