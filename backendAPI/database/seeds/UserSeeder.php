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
            'normalized_name' => 'FABIO',
            'email' => 'fabioTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC123',
        ]);

        DB::table('users')->insert([
            'name' => 'Goncalo',
            'normalized_name' => 'GONCALO',
            'email' => 'goncaloTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC124'
        ]);

        DB::table('users')->insert([
            'name' => 'Filipe',
            'normalized_name' => 'FILIPE',
            'email' => 'filipeTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC222'
        ]);

        DB::table('users')->insert([
            'name' => 'Pedro',
            'normalized_name' => 'PEDRO',
            'email' => 'pedroTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC223'
        ]);

        DB::table('users')->insert([
            'name' => 'Daniel',
            'normalized_name' => 'DANIEL',
            'email' => 'danielTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC333'
        ]);

        DB::table('users')->insert([
            'name' => 'Bernardo',
            'normalized_name' => 'BERNARDO',
            'email' => 'bernardoTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC111'
        ]);

        DB::table('users')->insert([
            'name' => 'Claudio',
            'normalized_name' => 'CLAUDIO',
            'email' => 'claudioTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC131'
        ]);

        DB::table('users')->insert([
            'name' => 'Joao',
            'normalized_name' => 'JOAO',
            'email' => 'joaoTeste@hotmail.com',
            'password' => Hash::make('123456'),
            'internalcode' => 'ABC533'
        ]);
    }
}
