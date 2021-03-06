<?php

namespace Database\Seeders;

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
        $this->call([
            BranchOfficeSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            DatesSeeder::class,
            ShiftsSeeder::class,
            SpecialtySeeder::class,
            ConfigurationSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
