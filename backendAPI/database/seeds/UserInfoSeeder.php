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
            'nif' => '123456789',
            'birthday_date' => '1990-05-15',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '112233445',
            'address' => 'Rua das Flores, 123',
            'city' => 'Lisboa',
            'district' => 'Lisboa',
            'postal_code' => '1000-001',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '2',
            'class' => 'TPSI0633',
            'nif' => '987654321',
            'birthday_date' => '1985-12-10',
            'gender_id' => '2',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '998877665',
            'address' => 'Avenida da Liberdade, 456',
            'city' => 'Porto',
            'district' => 'Porto',
            'postal_code' => '4000-002',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '3',
            'class' => 'TPSI0644',
            'nif' => '987123456',
            'birthday_date' => '1992-08-25',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '665544332',
            'address' => 'Rua do Comércio, 789',
            'city' => 'Faro',
            'district' => 'Faro',
            'postal_code' => '8000-003',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '4',
            'class' => 'TPSI0622',
            'nif' => '456789123',
            'birthday_date' => '1988-03-18',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '443322111',
            'address' => 'Avenida Central, 101',
            'city' => 'Coimbra',
            'district' => 'Coimbra',
            'postal_code' => '3000-004',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '5',
            'class' => 'TPSI0622',
            'nif' => '321987654',
            'birthday_date' => '1995-11-30',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '112233445',
            'address' => 'Rua dos Aliados, 222',
            'city' => 'Braga',
            'district' => 'Braga',
            'postal_code' => '4700-005',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '6',
            'class' => 'GRSI0622',
            'nif' => '456123789',
            'birthday_date' => '1991-07-20',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '554433221',
            'address' => 'Avenida da República, 333',
            'city' => 'Aveiro',
            'district' => 'Aveiro',
            'postal_code' => '3800-006',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '7',
            'class' => 'GRSI0622',
            'nif' => '789456123',
            'birthday_date' => '1987-09-05',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '443322111',
            'address' => 'Praça da Batalha, 444',
            'city' => 'Viseu',
            'district' => 'Viseu',
            'postal_code' => '3500-007',
            'country_id' => '1',
        ]);

        DB::table('user_infos')->insert([
            'user_id' => '8',
            'class' => 'GRSI0622',
            'nif' => '789123456',
            'birthday_date' => '1993-04-12',
            'gender_id' => '1',
            'profile_picture_path' => 'defaultImageUsers/DefaultUser.png',
            'phone_number' => '998877665',
            'address' => 'Rua do Carmo, 555',
            'city' => 'Leiria',
            'district' => 'Leiria',
            'postal_code' => '2400-008',
            'country_id' => '1',
        ]);

    }
}
