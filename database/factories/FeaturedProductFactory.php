<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeaturedProduct>
 */
class FeaturedProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' =>$this->faker->numberBetween(1,20),
            'from_date' =>$this->faker->dateTimeThisMonth,
            'to_date' =>$this->faker->dateTimeThisYear
        ];
    }
}
