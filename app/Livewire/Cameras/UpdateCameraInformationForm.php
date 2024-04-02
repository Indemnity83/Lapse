<?php

namespace App\Livewire\Cameras;

use App\Actions\Cameras\UpdateCameraInformation;
use Livewire\Component;

class UpdateCameraInformationForm extends Component
{
    public $camera;

    public $state = [];

    public function mount($camera): void
    {
        $this->camera = $camera;

        $this->state = $camera->withoutRelations()->toArray();
    }

    public function updateCameraInformation(UpdateCameraInformation $updateCameraInformation): void
    {
        $this->resetErrorBag();

        $updateCameraInformation->handle($this->camera, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('cameras.update-camera-information-form');
    }
}
