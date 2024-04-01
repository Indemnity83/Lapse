<?php

namespace App\Livewire\Cameras;

use App\Models\Camera;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

    public function updateCameraInformation(): void
    {
        $this->resetErrorBag();

        // TODO: move this into an action
        $this->update($this->camera, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('cameras.update-camera-information-form');
    }

    protected function update(Camera $camera, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', Rule::unique('cameras')->ignore($camera->id)],
            'url' => ['required', 'url', 'max:255'],
        ])->validateWithBag('updateCameraInformation');

        $camera->forceFill([
            'name' => $input['name'],
            'url' => $input['url'],
        ])->save();
    }
}
