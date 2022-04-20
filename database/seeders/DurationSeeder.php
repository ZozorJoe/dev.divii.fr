<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $durations = [
            [
                'label' => '15 minutes',
                'credit' => '15',
                'price' => '15',
                'currency' => 'EUR',
                'delay' => '+15 minutes',
            ],
            [
                'label' => '30 minutes',
                'credit' => '30',
                'price' => '30',
                'currency' => 'EUR',
                'delay' => '+30 minutes',
            ],
            [
                'label' => '45 minutes',
                'credit' => '45',
                'price' => '45',
                'currency' => 'EUR',
                'delay' => '+45 minutes',
            ],
            [
                'label' => '60 minutes',
                'credit' => '60',
                'price' => '60',
                'currency' => 'EUR',
                'delay' => '+60 minutes',
            ],
        ];
        foreach ($durations as $duration){
            DB::table('durations')->insert($duration);
        }
    }
}
