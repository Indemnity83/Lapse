<?php

namespace App\Livewire\Cameras;

use App\Models\Camera;
use Livewire\Component;

class Preview extends Component
{
    public Camera $camera;

    public function mount(Camera $camera)
    {
        $this->camera = $camera;
    }

    public function render()
    {
        return view('cameras.preview');
    }
}
