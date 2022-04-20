<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            '/img/icon/icon-4.svg',
            '/img/icon/icon-5.svg',
            '/img/icon/icon-6.svg',
            '/img/icon/icon-7.svg',
            '/img/icon/icon-8.svg',
        ];
        foreach ($images as $key => $image){
            DB::table('files')->insert(
                [
                    'id' => $key + 1,
                    'name' => basename($image),
                    'path' => $image,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $disciplines = [
            'Sonothérapie',
            'Astrologie',
            'Cartomanie',
            'Chiromancie',
            'Pendule',
            'Voyance',
            'Numérologie',
            'Techniques énergétiques',
            'Tarologie',
        ];

        foreach ($disciplines as $key => $discipline){

            DB::table('disciplines')->insert(
                [
                    'name' => $discipline,
                    'image_id' => (($key % count($images))  + 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
