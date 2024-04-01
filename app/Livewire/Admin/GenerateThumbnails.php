<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class GenerateThumbnails extends Component
{
    public function generateThumbnails()
    {
        Artisan::call('media-library:regenerate', [
            '--only' => 'thumb',
        ]);
    }

    public function render()
    {
        return view('admin.generate-thumbnails');
    }
}
