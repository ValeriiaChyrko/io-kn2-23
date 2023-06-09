<?php

namespace Database\Factories;

use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transfer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'transfer_date' => now(),
            'transfer_number' => $this->faker->numberBetween(1, 10),
            'from_user_id' => $this->faker->numberBetween(1, 3),
            'to_user_id' => $this->faker->numberBetween(1, 3),
            'file_url' => 'some/file/url/for/test.txt',
            'confirmed' => $this->faker->boolean(50),
        ];
    }
}
