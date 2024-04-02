<?php

namespace App\Actions\Timelapses;

use App\Models\Lapse;
use Lorisleiva\Actions\Concerns\AsAction;

class PauseTimelapse
{
    use AsAction;

    public function handle(Lapse $lapse)
    {
        $lapse->is_paused = true;
        $lapse->save();
    }
}
