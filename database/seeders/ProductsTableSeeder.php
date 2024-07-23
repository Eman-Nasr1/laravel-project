<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Faker\Factory as Faker;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productCount = DB::table('products')->count();  

        // Ensure there are categories available  
        if ($productCount > 0) {  
            foreach (DB::table('products')->get() as $product) {  
                DB::table('products')->where('id', $product->id)  
                    ->update(['category_id' => rand(1, 5)]);  
            }  
        } 
    }
}
