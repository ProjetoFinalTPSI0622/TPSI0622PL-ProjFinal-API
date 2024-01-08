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
            ['priority_name' => 'Low'],
            ['priority_name' => 'Medium'],
            ['priority_name' => 'High'],
        ]);
    }
}
