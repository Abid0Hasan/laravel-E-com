<?php

use Illuminate\Database\Seeder;

use App\Category;
use App\Product;
use App\Review;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call( UsersTableSeeder::class);

    	factory(Category::class, 10)->create();
    	factory(Product::class, 50)->create();
    	factory(Review::class, 300)->create();

    }
}
