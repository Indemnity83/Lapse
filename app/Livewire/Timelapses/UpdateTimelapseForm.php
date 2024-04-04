<?php

namespace App\Livewire\Timelapses;

use App\Actions\Timelapses\UpdateTimelapse;
use App\Models\Camera;
use App\Models\Timelapse;
use Livewire\Component;

class UpdateTimelapseForm extends Component
{
    public $timelapse;

    public $cameras;

    public $state = [];

    public function mount(Timelapse $timelapse): void
    {
        $this->timelapse = $timelapse;
        $this->cameras = Camera::all();

        $this->state = [
            'name' => $timelapse->name,
            'interval' => $timelapse->interval,
            'cameras' => array_fill_keys($timelapse->cameras->pluck('id')->all(), true),
        ];
    }

    public function updateTimelapse(UpdateTimelapse $updateTimelapse): void
    {
        $this->resetErrorBag();

        $updateTimelapse->handle($this->timelapse, $this->state);

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('timelapses.update-timelapse-form');
    }
}
