<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            '10 crédits' => ['price' => 35, 'credit' => 10],
            '20 crédits' => ['price' => 65, 'credit' => 20],
            '30 crédits' => ['price' => 95, 'credit' => 30],
            '40 crédits' => ['price' => 120, 'credit' => 40],
            '50 crédits' => ['price' => 150, 'credit' => 50],
        ];
        foreach ($products as $product => $value){
            DB::table('products')->insert(
                [
                    'name' => $product,
                    'price' => $value['price'],
                    'currency' => 'EUR',
                    'vat' => 0,
                    'credit' => $value['credit'],
                    'gift' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
