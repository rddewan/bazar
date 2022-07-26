<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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

        $thumbnail = $this->faker->picsum(storage_path('app/public/product/thumbnails'),100,100,false);
        $image = $this->faker->picsum(storage_path('app/public/product/images'),500,500,false);
        $url_thumbnail = Storage::url('product/thumbnails/'.$thumbnail);
        $url_product = Storage::url('product/images/'.$image);

        return [
            'sku' =>$this->faker->numberBetween(10000, 900000),
            'name' =>$this->faker->realText(15),
            'short_description' =>$this->faker->sentence(2, true),
            'long_description' =>$this->faker->paragraph(3,true),
            'thumbnail' =>$url_thumbnail,
            'images' =>$url_product,
            'brand_id' =>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'category_id' =>$this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
            'is_active' =>$this->faker->boolean(),
        ];
    }
}
