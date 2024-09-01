<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Order::class;
    public function definition()
    {
        return [
            
            'user_id' => \App\Models\User::factory(),
            'menu_id' => \App\Models\Menu::factory(),
            'quantity' => $this->faker->numberBetween(1, 10),
            'delivery_date' => $this->faker->date,
            'delivery_address' => $this->faker->word(),
            'status' => 'pending',
        ];
    }
}
