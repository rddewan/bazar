<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
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

        $thumbnail = $this->faker->picsum(storage_path('app/public/brand/thumbnails'),100,100,false);
        $image = $this->faker->picsum(storage_path('app/public/brand/images'),500,500,false);
        $url_thumbnail = Storage::url('brand/thumbnails/'.$thumbnail);
        $url_product = Storage::url('brand/images/'.$image);

        return [
            'name' =>$this->faker->unique()->word(),
            'description' =>$this->faker->sentence(3, true),
            'thumbnail' =>$url_thumbnail,
            'image' =>$url_product,
            'is_active' =>$this->faker->boolean(),

        ];
    }
}
