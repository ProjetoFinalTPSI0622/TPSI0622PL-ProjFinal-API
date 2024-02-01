<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'class' => 'TPSI0622',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'city' => 'Lisboa',
            'district' => 'Lisboa',
            'postal_code' => '1111-111',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '2',
            'class' => 'TPSI0633',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'city' => 'Lisboa',
            'district' => 'Lisboa',
            'postal_code' => '1111-111',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '3',
            'class' => 'TPSI0644',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'city' => 'Lisboa',
            'district' => 'Lisboa',
            'postal_code' => '1111-111',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '4',
            'class' => 'TPSI0622',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'city' => 'Lisboa',
            'district' => 'Lisboa',
            'postal_code' => '1111-111',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '5',
            'class' => 'TPSI0622',
            'nif' => '111111111',
            'birthday_date' => '2001-01-01',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '111111111',
            'address' => 'aaa111',
            'city' => 'Lisboa',
            'district' => 'Lisboa',
            'postal_code' => '1111-111',
            'country_id' => '1',
        ]);
    }
}
