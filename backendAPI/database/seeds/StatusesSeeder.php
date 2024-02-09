<?php

use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            ['name' => 'Pendente', 'color' => '#c82d2d'],
            ['name' => 'Em Progresso', 'color' => '#d26c19'],
            ['name' => 'Completo', 'color' => '#2dae47'],
        ]);
    }
}
