<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new PicsumProvider($this->faker));
        $this->faker->addProvider(new LoremSpaceProvider($this->faker));

        $thumbnail = $this->faker->picsum(storage_path('app/public/category/thumbnails'),100,100,false);
        $product = $this->faker->picsum(storage_path('app/public/category/images'),500,500,false);
        $url_thumbnail = Storage::url('category/thumbnails/'.$thumbnail);
        $url_product = Storage::url('category/images/'.$product);

        return [
            'name' =>$this->faker->unique()->word(),
            'description' =>$this->faker->sentence(3, true),
            'thumbnail' =>$url_thumbnail,
            'image' =>$url_product,
            'is_active' =>$this->faker->boolean(),
        ];
    }
}
