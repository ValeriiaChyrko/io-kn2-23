<?php

namespace Database\Factories;

use App\Models\Writeoff;
use Illuminate\Database\Eloquent\Factories\Factory;

class WriteoffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Writeoff::class;

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
            'file_url' => 'some/file/url/for/test.txt',
            'confirmed' => $this->faker->boolean(50),
        ];
    }
}
