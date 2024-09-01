<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MerchantControllerTest extends TestCase
{

    use RefreshDatabase, WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function test_dashboard_access(){
        $user = User::factory()->create(['role' => 'merchant']);

        $response = $this->actingAs($user)->get('/merchant/dashboard');

        $response->assertStatus(200);

        $response->assertViewIs('merchant.dashboard');
        $response->assertSee('Welcome');

     }

     public function test_create_menu(){

        $user = User::factory()->create(['role'=>'merchant']);
        $response = $this->actingAs($user)->get('/merchant/menu/create');

        $response->assertStatus(200);
        $response->assertViewIs('merchant.create-menu');
     }
   
     public function test_order_list(){

        $user = User::factory()->create(['role' => 'merchant']);
        $order = Order::factory()->create();

        $response = $this->actingAs($user)->get('/merchant/orders', [
            'order_id' => $order->id
        ]);

        $response->assertStatus(200);

        $response->assertSee($order->id);
     }

     public function test_store_menu(){

        Storage::fake('public');
        $user = User::factory()->create(['role' => 'merchant']);
        $photo = UploadedFile::fake()->image('nasi.jpeg');

        $response = $this->actingAs($user)->post('/merchant/menu',[
            'name' => 'Nasi Bungkus',
            'description' => 'Nasi',
            'photo' => $photo,
            'price' => 500,

        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('merchant.dashboard'));
        $this->assertDatabaseHas('menus', [
            'merchant_id' => $user->id,
            'name' => 'Nasi Bungkus',
            'description' => 'Nasi',
            'price' => 500,
        ]);
      
        Storage::disk('public')->assertExists('menu_photos/' . $photo->hashName());
     }

     public function test_delivered_order(){
        $user = User::factory()->create(['role' => 'merchant']);
        $menu = Menu::factory()->create(['merchant_id' => $user->id]);
        $order = Order::factory()->create([
            'user_id' => $user->id,
            'menu_id' => $menu->id,
            'status' => 'paid'],
    );
      

        $response = $this->actingAs($user)->post(route('merchant.order.deliver', $order->id));

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'menu_id' => $menu->id,
            'status' => 'delivered']);

            $response->assertRedirect(route('merchant.orders'));
            $response->assertSessionHas('success', 'Order has been delivered.');
    

     }



     
}
