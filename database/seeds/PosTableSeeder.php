<?php

use Illuminate\Database\Seeder;
use App\Role;
class PosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'POS'
        ]);
    }
}
