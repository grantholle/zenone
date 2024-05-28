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

it('can add a new shipment', function (array $data, array $errors) {
    $response = $this->postJson(route('shipments.store'), $data);

    if (empty($errors)) {
        $response->assertCreated();
        expect($this->user->shipments()->count())->toBe(6);
        $this->assertDatabaseHas('shipments', [
            ...$data,
            'user_id' => $this->user->id,
        ]);
        $shipment = \App\Models\Shipment::tracking($data['tracking_number'])
            ->first();
        expect($shipment->weight)->not->toBeNull()
            ->and($shipment->origin)->not->toBeNull()
            ->and($shipment->destination)->not->toBeNull()
            ->and($shipment->status)->not->toBeNull();
    } else {
        $response->assertStatus(422)
            ->assertJsonValidationErrors($errors);
        $this->assertEquals(5, $this->user->shipments()->count());
    }
})->with([
    'missing fields' => fn () => [
        'data' => [
            'tracking_number' => null,
        ],
        'errors' => ['tracking_number']
    ],
    'valid fields' => fn () => [
        'data' => [
            'tracking_number' => null,
        ],
        'errors' => ['tracking_number']
    ],
]);
