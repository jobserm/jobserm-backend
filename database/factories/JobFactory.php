<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'compensation' => $this->faker->numberBetween(500, 50000),
            'description' => $this->faker->paragraph(),
            'requirement' => $this->faker->paragraph(),
            'province' => $this->faker->city(),
            'title' => $this->faker->jobTitle(),
        ];
    }
}
