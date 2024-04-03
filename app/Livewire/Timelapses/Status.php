<?php

namespace App\Livewire\Timelapses;

use App\Actions\Timelapses\PauseTimelapse;
use App\Actions\Timelapses\RunTimelapse;
use App\Models\Timelapse;
use Livewire\Component;

class Status extends Component
{
    public Timelapse $timelapse;

    public function mount(Timelapse $timelapse): void
    {
        $this->timelapse = $timelapse;
    }

    public function pauseTimelapse(PauseTimelapse $pauseTimelapse): void
    {
        $pauseTimelapse->handle($this->timelapse);
    }

    public function runTimelapse(RunTimelapse $runTimelapse): void
    {
        $runTimelapse->handle($this->timelapse);
    }

    public function render()
    {
        return view('timelapses.status');
    }
}
