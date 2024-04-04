<?php

namespace App\Actions\Cameras;

use App\Models\Camera;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCamera
{
    use AsAction;

    public function handle(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100', Rule::unique('cameras')],
            'url' => ['required', 'url'],
        ])->validateWithBag('createCamera');

        Camera::create([
            'name' => $input['name'],
            'url' => $input['url'],
        ]);
    }
}
