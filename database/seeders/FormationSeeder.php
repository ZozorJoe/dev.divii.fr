<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formations = [
            'Les bases de l\'Astrologie' => 20,
            'Les bases de la Voyance' => 50,
            'Les bases de la Numérologie' => 75,
            'Les Techniques énergétiques' => 5,
        ];
        foreach ($formations as $formation => $price){
            DB::table('formations')->insert(
                [
                    'name' => $formation,
                    'price' => $price,
                    'currency' => 'EUR',
                    'vat' => 0,
                    'user_id' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
