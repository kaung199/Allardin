<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        User::create([
            'name' => 'Super Admin',
            'phone' => '09789',
            'address' => 'admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Admin',
            'phone' => '09789',
            'address' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2
        ]);

        User::create([
            'name' => 'Delivery',
            'phone' => '09789',
            'address' => 'delivery',
            'email' => 'delivery@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3
        ]);

    }
}
