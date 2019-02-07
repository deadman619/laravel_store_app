<?php

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
    	for($i = 0; $i < 50; $i++) {
	        DB::table('products')->insert([
	        	'name' => str_random(10),
	            'sku' => rand(100, 10000),
	            'base_price' => rand(1,3000),
	            'description' => str_random(100),
	            'special_price' => rand(1,3000),
	            'image' => "https://loremflickr.com/3". rand(10,99) ."/240",
	            'status' => 1
	        ]);
    	}
    }
}
