<?php

namespace Database\Factories;

use App\Models\SoftwareModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SoftwareModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SoftwareModel::class;

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
