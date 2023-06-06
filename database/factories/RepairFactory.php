<?php

namespace Database\Factories;

use App\Models\Repair;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Repair::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start_date' => now(),
            'end_date' => now()->addDays(11),
            'user_id' => $this->faker->numberBetween(1, 3),
            'item_id' => $this->faker->numberBetween(1, 100),
            'provider_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
