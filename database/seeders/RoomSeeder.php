<?php

namespace Database\Seeders;

use App\Models\Chat\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('rooms')->truncate();
        DB::table('room_user')->truncate();

        $rooms = [
            [
                'title' => 'Private Chat',
            ],
            [
                'title' => 'Formation PHP',
            ],
            [
                'title' => 'Formation CSS',
            ],
        ];
        foreach ($rooms as $key => $room){
            DB::table('rooms')->insert(
                array_merge(
                    $room,
                    [
                        'created_at' => now()->addSeconds($key),
                        'updated_at' => now()->addSeconds($key),
                    ]
                ));
        }

        $values = [
            1 => [1,2],
            2 => [1,2,3,4],
            3 => [1,5,6,7,8,9,10,11,12,13,14],
        ];
        foreach ($values as $room_id => $users){
            DB::table('rooms')->insert(
                array_merge(
                    $room,
                    [
                        'created_at' => now()->addSeconds($key),
                        'updated_at' => now()->addSeconds($key),
                    ]
                ));

            foreach ($users as $user_id){
                DB::table('room_user')->insert([
                    'room_id' => $room_id,
                    'user_id' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        for ($i = 0; $i < 50; $i++){
            $room_id = DB::table('rooms')->insertGetId(
                [
                    'title' => 'Formation ' . $i,
                    'created_at' => now()->addSeconds($i),
                    'updated_at' => now()->addSeconds($i),
                ]
            );

            DB::table('room_user')->insert([
                'room_id' => $room_id,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('room_user')->insert([
                'room_id' => $room_id,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
