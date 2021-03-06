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
                "branch_office_id"=>1,
                "phone"=>"9613521645",
                "birthday"=>"1990-03-31",
            ]
        )->assignRole('admin');

        User::create(
            [
                "name"=>"Daniel",
                "last_name"=>"Guerra",
                "email"=>"dani@dani.com",
                "password"=>"pass1234",
                "branch_office_id"=>1,
                "phone"=>"9613521646",
                "birthday"=>"1990-03-31",
            ]
        )->assignRole('admin');

        User::create(
            [
                "name"=>"Admin",
                "last_name"=>"Admin",
                "email"=>"admin@admin.com",
                "password"=>"pass1234",
                "branch_office_id"=>2,
                "phone"=>"9613521647",
                "birthday"=>"1990-03-31",
            ]
        )->assignRole('admin');

        User::create(
            [
                "name"=>"Doctor",
                "last_name"=>"Doc",
                "email"=>"doc@doc.com",
                "password"=>"pass1234",
                "branch_office_id"=>1,
                "phone"=>"9613521648",
                "birthday"=>"1991-03-31",
            ]
        )->assignRole('doctor');

        User::create(
            [
                "name"=>"Patient",
                "last_name"=>"Pat",
                "email"=>"pat@pat.com",
                "password"=>"pass1234",
                "branch_office_id"=>1,
                "phone"=>"9613521649",
                "status_patient"=>"active",
                "birthday"=>"1990-03-31",
            ]
        )->assignRole('patient');

        User::create(
            [
                "name"=>"Patient",
                "last_name"=>"Pat",
                "email"=>"pat2@pat.com",
                "password"=>"pass1234",
                "branch_office_id"=>1,
                "phone"=>"9613521649",
                "status_patient"=>"inactive",
                "birthday"=>"1990-03-31",
            ]
        )->assignRole('patient');

        User::create(
            [
                "name"=>"Patient",
                "last_name"=>"Pat",
                "email"=>"pat3@pat.com",
                "password"=>"pass1234",
                "branch_office_id"=>1,
                "phone"=>"9613521649",
                "status_patient"=>"discharge",
                "birthday"=>"2021-03-30",
            ]
        )->assignRole('patient');

        User::create(
            [
                "name"=>"Patient",
                "last_name"=>"Pat",
                "email"=>"pat4@pat.com",
                "password"=>"pass1234",
                "branch_office_id"=>1,
                "phone"=>"9613521649",
                "status_patient"=>"pending",
                "birthday"=>"2021-03-31",
            ]
        )->assignRole('patient');

    }
}
