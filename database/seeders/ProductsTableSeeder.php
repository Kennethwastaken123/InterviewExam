<?php
       

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set('Asia/Manila');
        $product = [            
            ['product_name' => 'face mask', 'qty' => '150'],
            ['product_name' => 'face shield', 'qty' => '50'],
            ['product_name' => 'alcohol', 'qty' => '20'],
        ];
        foreach ($product as $product) {
            DB::table('product')->insert([
                'product_name' => $product['product_name'],
                'qty' => $product['qty'],
                'created_at' =>  date('Y-m-d H:i:s')
                
            ]);
        }
      
    }
}
