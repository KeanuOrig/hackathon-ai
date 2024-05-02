<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class TunedModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'tuned_model' => $this->faker->randomElement(['number-generator-model-ebz81k78enbf', 'animal-model-iusflflb4wd7', 'school-model-gnuk4yfgab41', 'food-model-7hqupfk4tli']),
            'updated_at' => now(),
            'created_at' => now(),
        ];
    }
}
