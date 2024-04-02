<?php

namespace App\Livewire\Lapses;

use App\Actions\Timelapses\UpdateLapseInformation;
use Livewire\Component;

class UpdateLapseInformationForm extends Component
{
    public $lapse;

    public $state = [];

    public function mount($lapse): void
    {
        $this->lapse = $lapse;

        $this->state = $lapse->withoutRelations()->toArray();
    }

    public function updateLapseName(UpdateLapseInformation $updateLapseInformation): void
    {
        $this->resetErrorBag();

        $updateLapseInformation->handle($this->lapse, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('lapses.update-lapse-information-form');
    }
}
