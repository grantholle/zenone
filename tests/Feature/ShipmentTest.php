<?php

beforeEach(function () {
    $this->user = signIn();
    seedShipments($this->user);
});

it('has shipments endpoint', function () {
    $this->getJson(route('shipments.index'))
        ->assertOk()
        ->assertJsonCount(5, 'data');
});
