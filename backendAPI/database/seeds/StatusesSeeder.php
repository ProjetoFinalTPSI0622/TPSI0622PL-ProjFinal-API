<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
