<?php

namespace App\Actions\Timelapses;

use App\Models\Timelapse;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateTimelapseInformation
{
    use AsAction;

    public function handle(Timelapse $timelapse, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'interval' => ['required', 'numeric', 'integer', 'min:1'],
        ])->validateWithBag('updateTimelapseInformation');

        $timelapse->forceFill([
            'name' => $input['name'],
            'interval' => $input['interval'],
        ])->save();
    }
}
