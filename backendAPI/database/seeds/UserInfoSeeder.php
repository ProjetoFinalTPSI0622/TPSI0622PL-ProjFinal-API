<?php

use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('user_infos')->insert([
            'user_id' => '1',
            'name' => 'Fabio',
            'normalized_name' => 'FABIO',
            'class' => 'TPSI0622',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'postal_code' => '1111-111',
            'city' => 'aaa',
            'district' => 'aaa',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '2',
            'name' => 'Goncalo',
            'normalized_name' => 'GONCALO',
            'class' => 'TPSI0633',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'postal_code' => '1111-111',
            'city' => 'aaa',
            'district' => 'aaa',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '3',
            'name' => 'Filipe',
            'normalized_name' => 'FILIPE',
            'class' => 'TPSI0644',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'postal_code' => '1111-111',
            'city' => 'aaa',
            'district' => 'aaa',
            'country_id' => '1',
        ]);

    }
}
