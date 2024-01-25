<?php

use Illuminate\Database\Seeder;

class GendersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            ['name' => 'Masculino',]
        ]);
        DB::table('genders')->insert([
            ['name' => 'Feminino',]
        ]);
        DB::table('genders')->insert([
            ['name' => 'Outro',]
        ]);
    }
}
