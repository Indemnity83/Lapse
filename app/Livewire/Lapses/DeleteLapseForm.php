<?php

namespace App\Livewire\Lapses;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteLapseForm extends Component
{
    public $lapse;

    public $confirmingLapseDeletion = false;

    public $clearMediaOnDelete = true;

    public $name;

    public function mount($lapse): void
    {
        $this->lapse = $lapse;
    }

    public function confirmLapseDeletion(): void
    {
        $this->resetErrorBag();

        $this->name = '';

        $this->dispatch('confirming-delete-lapse');

        $this->confirmingLapseDeletion = true;
    }

    public function deleteLapse()
    {
        $this->resetErrorBag();

        if ($this->name !== $this->lapse->name) {
            throw ValidationException::withMessages([
                'name' => [__('name does not match.')],
            ]);
        }

        // TODO: move this into an action
        DB::transaction(function () {
            if ($this->clearMediaOnDelete) {
                $this->lapse->snapshots->each->delete();
            } else {
                $this->lapse->snapshots->each->forgetCustomProperty('lapse_id');
            }
            $this->lapse->delete();
        });

        return redirect(route('lapses'));
    }

    public function render()
    {
        return view('lapses.delete-lapse-form');
    }
}
