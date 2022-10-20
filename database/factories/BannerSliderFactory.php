<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Mmo\Faker\LoremSpaceProvider;
use Mmo\Faker\PicsumProvider;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BannerSlider>
 */
class BannerSliderFactory extends Factory
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


        $image = $this->faker->picsum(storage_path('app/public/banner/images'),1400,480,false);
        $banner = Storage::url('banner/images/'.$image);

        return [
            'banner_id' => 1,
            'name' => 'home',
            'image' =>$banner,
            'is_active' => true,
        ];
    }
}
