<?php

namespace App\Livewire\Cameras;

use App\Actions\Cameras\UpdateCamera;
use Livewire\Component;

class UpdateCameraForm extends Component
{
    public $camera;

    public $state = [];

    public function mount($camera): void
    {
        $this->camera = $camera;

        $this->state = $camera->withoutRelations()->toArray();
    }

    public function updateCamera(UpdateCamera $updateCamera): void
    {
        $this->resetErrorBag();

        $updateCamera->handle($this->camera, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('cameras.update-camera-form');
    }
}
