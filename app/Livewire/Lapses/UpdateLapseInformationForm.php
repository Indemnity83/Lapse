<?php

namespace App\Livewire\Lapses;

use App\Models\Lapse;
use Illuminate\Support\Facades\Validator;
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

    public function updateLapseName(): void
    {
        $this->resetErrorBag();

        // TODO: move this into an action
        $this->updateLapse($this->lapse, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('lapses.update-lapse-information-form');
    }

    protected function updateLapse(Lapse $lapse, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'interval' => ['required', 'numeric', 'integer', 'min:1'],
        ])->validateWithBag('updateLapseName');

        $lapse->forceFill([
            'name' => $input['name'],
            'interval' => $input['interval'],
        ])->save();
    }
}
