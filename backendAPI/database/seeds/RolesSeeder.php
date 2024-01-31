<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role' => 'admin',
        ]);

        DB::table('roles')->insert([
            'role' => 'user',
        ]);
        DB::table('roles')->insert([
            'role' => 'technician',
        ]);

    }
}
