<?php

namespace Database\Factories;

use App\Models\HardwareModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class HardwareModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HardwareModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::ucfirst($this->faker->domainWord),
        ];
    }
}
