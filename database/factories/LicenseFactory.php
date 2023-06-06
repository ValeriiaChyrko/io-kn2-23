<?php

namespace Database\Factories;

use App\Models\License;
use Illuminate\Database\Eloquent\Factories\Factory;

class LicenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = License::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'software_model_id' => $this->faker->numberBetween(1, 25),
            'item_id' => $this->faker->numberBetween(1, 100),
            'invoice_id' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(120, 890),
            'owner_id' => $this->faker->numberBetween(1, 3),
            //'end_date' => now()->addMonths(17),
        ];
    }
}
