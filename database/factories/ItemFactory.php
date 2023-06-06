<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type_id' => $this->faker->numberBetween(1, 50),
            'hardware_model_id' => $this->faker->numberBetween(1, 100),
            'department_id' => $this->faker->numberBetween(1, 100),
            'owner_id' => $this->faker->numberBetween(1, 3),
            'status_id' => $this->faker->numberBetween(1, 6),
            'inventory_number' => $this->faker->numberBetween(10000, 99999),
            'price' => $this->faker->numberBetween(100, 12000),
            'invoice_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
