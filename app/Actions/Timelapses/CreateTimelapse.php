<?php

namespace App\Actions\Timelapses;

use App\Models\Timelapse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateTimelapse
{
    use AsAction;

    public function handle(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100', Rule::unique('timelapses')],
            'interval' => ['required', 'numeric', 'integer', 'min:1'],
            'cameras' => ['required', 'array', 'min:1'],
        ])->validateWithBag('createTimelapse');

        $timelapse = Timelapse::create([
            'name' => $input['name'],
            'interval' => $input['interval'],
        ]);

        $timelapse->cameras()->sync(array_keys($input['cameras']));
    }
}
