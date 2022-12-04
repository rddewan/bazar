<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'price' =>$this->faker->randomFloat(2,5.20,100),
            'discount' =>$this->faker->numberBetween(2,10),
            'from_date' =>$this->faker->dateTime,
            'to_date' =>$this->faker->dateTime
        ];
    }
}
