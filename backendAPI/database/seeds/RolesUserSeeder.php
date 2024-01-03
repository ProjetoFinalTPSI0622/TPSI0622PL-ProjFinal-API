<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_user')->insert([
            'roles_id' => '1',
            'user_id' => '1',
        ]);

        DB::table('roles_user')->insert([
            'roles_id' => '1',
            'user_id' => '2',
        ]);

        DB::table('roles_user')->insert([
            'roles_id' => '1',
            'user_id' => '3',
        ]);
    }
}
