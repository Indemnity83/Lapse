<?php

namespace App\Livewire\Cameras;

use App\Actions\Cameras\DeleteCamera;
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

    public function deleteCamera(DeleteCamera $deleteCamera)
    {
        $this->resetErrorBag();

        if ($this->name !== $this->camera->name) {
            throw ValidationException::withMessages([
                'name' => [__('name does not match.')],
            ]);
        }

        $deleteCamera->handle($this->camera);

        return redirect(route('cameras.index'));
    }

    public function render()
    {
        return view('cameras.delete-camera-form');
    }
}
