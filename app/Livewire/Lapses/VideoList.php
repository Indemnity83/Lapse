<?php

namespace App\Livewire\Lapses;

use App\Models\Lapse;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class VideoList extends Component
{
    public $lapse;

    public MediaCollection $videos;

    public function mount(Lapse $lapse)
    {
        $this->lapse = $lapse;
        $this->videos = $lapse->getMedia('timelapse');
    }

    public function delete($mediaId)
    {
        Media::findOrfail($mediaId)->delete();
        $this->videos = $this->lapse->getMedia('timelapse');
    }

    public function render()
    {
        return view('lapses.video-list');
    }
}
