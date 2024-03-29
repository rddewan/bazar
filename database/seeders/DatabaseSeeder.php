<?php

namespace Database\Seeders;

use App\Models\BannerSlider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            BannerSeeder::class,
            BannerSliderSeeder::class,
            FeaturedProductSeeder::class
        ]);
    }
}
