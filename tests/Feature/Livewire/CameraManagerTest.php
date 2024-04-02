<?php

use App\Livewire\Cameras\CameraManager;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CameraManager::class)
        ->assertStatus(200);
});
