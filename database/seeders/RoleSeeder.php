<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $global_admin = Role::create(['name' => 'global_admin']);
        $staff = Role::create(['name' => 'staff']);
        $local_admin = Role::create(['name' => 'local_admin']);
    }
}
