<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\Price;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->times(100)
            ->create()
            ->each(function ($product) {
                Price::factory()
                    ->create(['product_id' =>$product->id,]);

                Inventory::factory()
                    ->create(['product_id' =>$product->id,]);

                for ($i = 1; $i <= 3; $i++) {
                    ProductImage::factory()
                        ->create(['product_id' =>$product->id]);
                }

            });
    }
}
