<?php

test('example', function () {
    $response = $this->get('dashboard');

    $response->assertStatus(200);
});
