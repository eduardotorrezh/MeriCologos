<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                "name"=>"Eduardo",
                "last_name"=>"Torres",
                "email"=>"ed@ed.com",
                "password"=>"pass1234",
                "branch_office_id"=>1
            ]
        )->assignRole('admin');

        User::create(
            [
                "name"=>"Daniel",
                "last_name"=>"Guerra",
                "email"=>"dani@dani.com",
                "password"=>"pass1234",
                "branch_office_id"=>1
            ]
        )->assignRole('admin');

        User::create(
            [
                "name"=>"Admin",
                "last_name"=>"Admin",
                "email"=>"admin@admin.com",
                "password"=>"pass1234",
                "branch_office_id"=>2
            ]
        )->assignRole('admin');

        User::create(
            [
                "name"=>"Doctor",
                "last_name"=>"Doc",
                "email"=>"doc@doc.com",
                "password"=>"pass1234",
                "branch_office_id"=>1
            ]
        )->assignRole('doctor');

        User::create(
            [
                "name"=>"Patient",
                "last_name"=>"Pat",
                "email"=>"pat@pat.com",
                "password"=>"pass1234",
                "branch_office_id"=>1
            ]
        )->assignRole('patient');

    }
}
