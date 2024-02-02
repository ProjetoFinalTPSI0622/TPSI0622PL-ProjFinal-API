<?php

use Illuminate\Database\Seeder;

class CommentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comment_types')->insert([
            ['name' => 'Public',],
        ]);
        DB::table('comment_types')->insert([
            ['name' => 'Private',],
        ]);
    }
}
