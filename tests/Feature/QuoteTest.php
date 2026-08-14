<?php

use App\Models\Quote;
use App\Models\User;

test('guests cannot access quotes', function () {
    $this->get(route('quotes.index'))->assertRedirect(route('login'));
    $this->get(route('quotes.create'))->assertRedirect(route('login'));
    $this->post(route('quotes.store'), [])->assertRedirect(route('login'));
});

test('can list own quotes', function () {
    $user = User::factory()->create();
    Quote::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->get(route('quotes.index'));

    $response->assertOk();
    $response->assertSee($user->quotes->first()->client_name);
});

test('cannot see other users quotes', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $other->id]);

    $this->actingAs($user)->get(route('quotes.show', $quote))->assertForbidden();
    $this->actingAs($user)->get(route('quotes.edit', $quote))->assertForbidden();
});

test('can create a quote with items', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('quotes.store'), [
        'client_name' => 'Jane Doe',
        'client_email' => 'jane@example.com',
        'items' => [
            ['description' => 'Web design', 'quantity' => 1, 'unit_price' => 500],
            ['description' => 'Hosting', 'quantity' => 12, 'unit_price' => 20],
        ],
    ]);

    $response->assertRedirect(route('quotes.index'));

    $quote = $user->quotes()->first();
    expect($quote)->not->toBeNull();
    expect($quote->client_name)->toBe('Jane Doe');
    expect($quote->items)->toHaveCount(2);
    expect((float) $quote->total)->toBe(740.00);
});

test('requires at least one item', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('quotes.store'), [
        'client_name' => 'Jane Doe',
        'client_email' => 'jane@example.com',
        'items' => [],
    ]);

    $response->assertSessionHasErrors('items');
});

test('can update a quote', function () {
    $user = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->put(route('quotes.update', $quote), [
        'client_name' => 'Updated Name',
        'client_email' => 'updated@example.com',
        'items' => [
            ['description' => 'New service', 'quantity' => 2, 'unit_price' => 100],
        ],
    ]);

    $response->assertRedirect(route('quotes.index'));

    $quote->refresh();
    expect($quote->client_name)->toBe('Updated Name');
    expect($quote->items)->toHaveCount(1);
    expect((float) $quote->total)->toBe(200.00);
});

test('can delete a quote', function () {
    $user = User::factory()->create();
    $quote = Quote::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('quotes.destroy', $quote));

    $response->assertRedirect(route('quotes.index'));
    expect(Quote::find($quote->id))->toBeNull();
});
