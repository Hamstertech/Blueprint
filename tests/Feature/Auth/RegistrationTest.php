<?php

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('new users can register', function () {
    Event::fake();
    Notification::fake();

    $data = [
        'name' => 'Test User',
        'email' => 'sky.etherington@ne6.studio',
        'phone' => '+447777777777',
    ];

    $this->post(route('register'), $data)->assertJsonStructure([
        'message',
    ]);

    $this->assertGuest();
    Event::assertDispatched(Registered::class);
});
