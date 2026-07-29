<?php

use App\Models\User;

it('shows the reports dashboard for authenticated users', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('reports.index'));

    $response->assertOk()
        ->assertSee('Reports')
        ->assertSee('Inventory movement');
});
