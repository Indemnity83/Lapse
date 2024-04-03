<?php

namespace App\Livewire\Timelapses;

use App\Actions\Timelapses\DeleteTimelapse;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class DeleteTimelapseForm extends Component
{
    public $timelapse;

    public $confirmingTimelapseDeletion = false;

    public $clearMediaOnDelete = true;

    public $name;

    public function mount($timelapse): void
    {
        $this->timelapse = $timelapse;
    }

    public function confirmTimelapseDeletion(): void
    {
        $this->resetErrorBag();

        $this->name = '';

        $this->dispatch('confirming-delete-timelapse');

        $this->confirmingTimelapseDeletion = true;
    }

    public function deleteTimelapse(DeleteTimelapse $deleteTimelapse)
    {
        $this->resetErrorBag();

        if ($this->name !== $this->timelapse->name) {
            throw ValidationException::withMessages([
                'name' => [__('name does not match.')],
            ]);
        }

        $deleteTimelapse->handle($this->timelapse, $this->clearMediaOnDelete);

        return redirect(route('timelapses.index'));
    }

    public function render()
    {
        return view('timelapses.delete-timelapse-form');
    }
}
