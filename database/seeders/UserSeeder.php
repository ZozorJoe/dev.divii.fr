<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'B2C',
                'role' => User\Administrator::ROLE,
                'email' => 'admin@exemple.com',
                'password' => Hash::make('asdf1234!'),
            ],
            [
                'first_name' => 'Expert',
                'last_name' => 'B2C',
                'role' => User\Expert::ROLE,
                'email' => 'expert@exemple.com',
                'password' => Hash::make('asdf1234!'),
            ],
            [
                'first_name' => 'Customer',
                'last_name' => 'B2C',
                'role' => User\Customer::ROLE,
                'email' => 'customer@exemple.com',
                'password' => Hash::make('asdf1234!'),
            ],
        ];
        foreach ($users as $user){
            DB::table('users')->insert(
                array_merge(
                    $user,
                    [
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                )
            );
        }

        User::factory()
            ->role()
            ->count(100)
            ->create();
    }
}
