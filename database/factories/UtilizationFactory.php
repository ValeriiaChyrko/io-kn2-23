<?php

namespace Database\Factories;

use App\Models\Utilization;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Utilization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(10000, 99999),
            'date' => now(),
            'user_id' => $this->faker->numberBetween(1, 3),
            'provider_id' => $this->faker->numberBetween(1, 100),
            'file_url' => 'some/file/url/for/test.txt',
            'confirmed' => $this->faker->boolean(50),
        ];
    }
}
