<?php

namespace App\Livewire\Lapses;

use App\Actions\Timelapses\PauseTimelapse;
use App\Actions\Timelapses\RunTimelapse;
use App\Models\Lapse;
use Livewire\Component;

class Status extends Component
{
    public Lapse $lapse;

    public function mount(Lapse $lapse): void
    {
        $this->lapse = $lapse;
    }

    public function pauseLapse(PauseTimelapse $pauseTimelapse): void
    {
        $pauseTimelapse->handle($this->lapse);
    }

    public function runLapse(RunTimelapse $runTimelapse): void
    {
        $runTimelapse->handle($this->lapse);
    }

    public function render()
    {
        return view('lapses.status');
    }
}
