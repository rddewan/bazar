<?php

namespace Database\Seeders;

use App\Models\FeaturedProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeaturedProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeaturedProduct::factory()->times(20)->create();
    }
}
