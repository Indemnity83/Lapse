<?php

namespace App\Livewire\Lapses;

use App\Models\Lapse;
use Livewire\Component;

class Status extends Component
{
    public Lapse $lapse;

    public function mount(Lapse $lapse): void
    {
        $this->lapse = $lapse;
    }

    public function pauseLapse(): void
    {
        // TODO: Turn this into an action
        $this->lapse->pause();
    }

    public function runLapse(): void
    {
        // TODO: Turn this into an action
        $this->lapse->run();
    }

    public function render()
    {
        return view('lapses.status');
    }
}
