<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specialty::create(["name"=>"Especialidad1"]);
        Specialty::create(["name"=>"Especialidad2"]);
    }
}
