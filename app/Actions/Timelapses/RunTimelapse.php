<?php

namespace App\Actions\Timelapses;

use App\Models\Lapse;
use Lorisleiva\Actions\Concerns\AsAction;

class RunTimelapse
{
    use AsAction;

    public function handle(Lapse $lapse)
    {
        $lapse->is_paused = false;
        $lapse->save();
    }
}
