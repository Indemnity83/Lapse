<?php

namespace App\Actions\Timelapses;

use App\Models\Timelapse;
use Lorisleiva\Actions\Concerns\AsAction;

class PauseTimelapse
{
    use AsAction;

    public function handle(Timelapse $timelapse)
    {
        $timelapse->is_paused = true;
        $timelapse->save();
    }
}
