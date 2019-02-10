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
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@thissite.com',
            'password' => bcrypt('admin1')
        ]);

        DB::table('taxes')->insert([
            'name' => 'Standard',
            'enabled' => 1,
            'tax_rate' => 21,
            'global_discount' => 0
        ]);
        
    	for($i = 0; $i < 20; $i++) {
            $price = rand(1,3000);
            $taxed = $price + ($price * (21/100));
	        DB::table('products')->insert([
	        	'name' => str_random(10),
	            'sku' => rand(100, 10000),
	            'base_price' => $price,
	            'description' => str_random(100),
	            'image' => "https://loremflickr.com/3". rand(10,99) ."/240",
	            'status' => 1,
                'post_tax_price' => $taxed,
                'consumer_price' => $taxed
	        ]);
    	}

        for($i = 0; $i < 50; $i++) {
            DB::table('reviews')->insert([
                'name' => str_random(5),
                'review' => str_random(10),
                'rating' => rand(1,5),
                'product_id' => rand(1, 20)
            ]);
        }
    }
}
