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
            'id' => 1,
            'name' => 'Super Admin',
            'phone' => '09789',
            'address' => 'admin',
            'email' => 'familysuperadmin@gmail.com',
            'password' => Hash::make('Family@123@superadmin'),
            'role_id' => 1
        ]);

    }
}
