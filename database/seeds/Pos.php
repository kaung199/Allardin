<?php

use Illuminate\Database\Seeder;
use App\Role;
class Pos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'POS-Admin'
        ]);
    }
}
