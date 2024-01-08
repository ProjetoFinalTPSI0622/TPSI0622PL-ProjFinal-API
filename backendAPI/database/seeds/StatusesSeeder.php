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
            ['status_name' => 'Pending'],
            ['status_name' => 'In Progress'],
            ['status_name' => 'Completed'],
        ]);
    }
}
