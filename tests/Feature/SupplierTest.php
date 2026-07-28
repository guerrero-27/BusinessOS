<?php

use App\Models\Supplier;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('supplier index page loads', function () {
    Supplier::create([
        'name' => 'Acme Supplies',
        'contact_person' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '09171234567',
        'address' => 'Makati City',
        'tax_id' => 'TAX-001',
        'is_active' => true,
    ]);

    $response = $this->get(route('suppliers.index'));

    $response->assertOk();
    $response->assertSee('Acme Supplies');
});

test('a supplier can be created', function () {
    $response = $this->post(route('suppliers.store'), [
        'name' => 'Global Trading',
        'contact_person' => 'John Smith',
        'email' => 'john@example.com',
        'phone' => '09181234567',
        'address' => 'Quezon City',
        'tax_id' => 'TAX-002',
        'is_active' => true,
    ]);

    $response->assertRedirect(route('suppliers.index'));
    $this->assertDatabaseHas('suppliers', ['name' => 'Global Trading']);
});
