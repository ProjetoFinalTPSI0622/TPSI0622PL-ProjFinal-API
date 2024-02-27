<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RolesUserSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PrioritiesSeeder::class);
        $this->call(StatusesSeeder::class);
        $this->call(GendersSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(UserInfoSeeder::class);
        $this->call(CommentTypesSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(TicketsSeeder::class);

    }
}
