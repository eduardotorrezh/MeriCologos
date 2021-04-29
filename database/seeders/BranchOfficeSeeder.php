<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BranchOffice;

class BranchOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BranchOffice::create([
            "name"=>"Oficina central",
        ]);

        BranchOffice::create([
            "name"=>"Sucursal aledaña",
        ]);
    }
}
