<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;

class CustomerControllerTest extends TestCase
{
use RefreshDatabase, WithoutMiddleware;

/**
* Test dashboard access.
*
* @return void
*/
public function test_dashboard_access()
{
// Create a user
$user = User::factory()->create();

// Authenticate the user
$response = $this->actingAs($user)->get('/customer/dashboard');

// Assert the response status
$response->assertStatus(200);

// Optionally assert view or data presence
$response->assertViewIs('customer.dashboard');
$response->assertSee('Welcome');
}

/**
* Test create order.
*
* @return void
*/
    public function test_create_order()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a menu
        $menu = Menu::factory()->create();

        // Authenticate the user
        $response = $this->actingAs($user)->post('/customer/order/store', [
            'menu_id' => $menu->id,
            'quantity' => 2,
            'delivery_date' => now()->addDays(1)->toDateString(),
            'delivery_address' => 'Jl. Ciputat'
        ]);

        // Assert the response status
        $response->assertStatus(302); // Redirect after store

        // Assert the order is created
        $this->assertDatabaseHas('orders', [
            'menu_id' => $menu->id,
            'quantity' => 2,
            'status' => 'pending',
        ]);
    }

/**
* Test view orders.
*
* @return void
*/
public function test_view_orders()
{
// Create a user and orders
$user = User::factory()->create();
$order = Order::factory()->create([
'user_id' => $user->id,
]);

// Authenticate the user
$response = $this->actingAs($user)->get('/customer/orders');

// Assert the response status
$response->assertStatus(200);

// Assert the order is visible
$response->assertSee($order->id);
}
}