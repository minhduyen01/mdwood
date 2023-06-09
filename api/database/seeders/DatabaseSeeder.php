<?php

namespace Database\Seeders;

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
        \App\Models\User::factory(1)->create();
        // \App\Models\TypeProduct::factory(10)->create();
        // \App\Models\Category::factory(30)->create();
        // \App\Models\Supplier::factory(10)->create();
        // \App\Models\Product::factory(300)->create();
        // \App\Models\Image::factory(1500)->create();
        // \App\Models\Slide::factory(5)->create();
        // \App\Models\Bill::factory(50)->create();
        // \App\Models\BillDetail::factory(150)->create();
    }
}
