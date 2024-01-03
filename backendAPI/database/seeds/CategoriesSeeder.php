<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['category_name' => 'Salas'],
            ['category_name' => 'Manutenção'],
            ['category_name' => 'Jardim'],
        ]);
    }
}
