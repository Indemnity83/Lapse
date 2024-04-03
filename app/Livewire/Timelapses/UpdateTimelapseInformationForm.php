<?php

namespace App\Livewire\Timelapses;

use App\Actions\Timelapses\UpdateTimelapseInformation;
use Livewire\Component;

class UpdateTimelapseInformationForm extends Component
{
    public $timelapse;

    public $state = [];

    public function mount($timelapse): void
    {
        $this->timelapse = $timelapse;

        $this->state = $timelapse->withoutRelations()->toArray();
    }

    public function updateTimelapseName(UpdateTimelapseInformation $updateTimelapseInformation): void
    {
        $this->resetErrorBag();

        $updateTimelapseInformation->handle($this->timelapse, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('timelapses.update-timelapse-information-form');
    }
}
