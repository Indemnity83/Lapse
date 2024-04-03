<?php

namespace App\Actions\Timelapses;

use App\Models\Timelapse;
use Lorisleiva\Actions\Concerns\AsAction;

class RunTimelapse
{
    use AsAction;

    public function handle(Timelapse $timelapse)
    {
        $timelapse->is_paused = false;
        $timelapse->save();
    }
}
