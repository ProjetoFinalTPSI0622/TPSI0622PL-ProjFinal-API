<?php

use Illuminate\Database\Seeder;

class PrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert([
            ['name' => 'Baixa'],
            ['name' => 'Média'],
            ['name' => 'Alta'],
        ]);
    }
}
