<?php

namespace App\Livewire\Lapses;

use App\Actions\Timelapses\DeleteLapse;
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

    public function deleteLapse(DeleteLapse $deleteLapse)
    {
        $this->resetErrorBag();

        if ($this->name !== $this->lapse->name) {
            throw ValidationException::withMessages([
                'name' => [__('name does not match.')],
            ]);
        }

        $deleteLapse->handle($this->lapse, $this->clearMediaOnDelete);

        return redirect(route('lapses.index'));
    }

    public function render()
    {
        return view('lapses.delete-lapse-form');
    }
}
