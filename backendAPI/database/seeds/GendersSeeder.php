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
            ['name' => 'Masculino'],
            ['name' => 'Feminino'],
            ['name' => 'Outro']
        ]);
    }
}
