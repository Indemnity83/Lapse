<?php

namespace App\Actions\Cameras;

use App\Models\Camera;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteCamera
{
    use AsAction;

    public function handle(Camera $camera): void
    {
        $camera->snapshots->each->delete();
        $camera->delete();
    }
}
