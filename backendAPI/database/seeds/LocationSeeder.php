<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locationsList = [
            'Porto',
            'Lisboa',
            'Faro',
        ];

        foreach($locationsList as $location){
            DB::table('locations')->insert([
                'name' => $location,
            ]);
        }
    }
}
