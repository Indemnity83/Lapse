<?php

namespace App\Livewire\Timelapses;

use App\Actions\Timelapses\CreateTimelapse;
use App\Models\Camera;
use App\Models\Timelapse;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class TimelapseManager extends Component
{
    public Collection $timelapses;

    public Collection $cameras;

    public $state;

    public function mount(): void
    {
        $this->timelapses = Timelapse::all();
        $this->cameras = Camera::all();

        $this->state = [
            'name' => '',
            'interval' => 5,
            'cameras' => [],
        ];
    }

    public function createTimelapse(CreateTimelapse $createTimelapse): void
    {
        $this->resetErrorBag();

        $createTimelapse->handle($this->state);

        $this->state = [
            'name' => '',
            'interval' => 5,
            'cameras' => [],
        ];

        $this->timelapses = Timelapse::all();

        $this->dispatch('saved');
    }

    public function render(): View
    {
        return view('timelapses.timelapse-manager');
    }
}
