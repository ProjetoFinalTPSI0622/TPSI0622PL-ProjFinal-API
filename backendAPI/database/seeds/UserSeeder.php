<?php

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
        DB::table('users')->insert([
            'name' => 'Fabio',
            'email' => 'fabiomiguel3.10@gmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC123',
        ]);

        DB::table('users')->insert([
            'name' => 'Goncalo',
            'email' => 'goncaloTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC124'
        ]);

        DB::table('users')->insert([
            'name' => 'Filipe',
            'email' => 'filipeTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC222'
        ]);

        DB::table('users')->insert([
            'name' => 'Pedro',
            'email' => 'pedroTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC223'
        ]);

        DB::table('users')->insert([
            'name' => 'Daniel',
            'email' => 'danielTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC333'
        ]);
    }
}
