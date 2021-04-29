<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $test = Permission::create(['name' => 'testpermissions']);
        $createUser = Permission::create(['name' => 'users.store']);
        $updateUser = Permission::create(['name' => 'users.update']);
        $deleteUser = Permission::create(['name' => 'users.delete']);
        $showUser = Permission::create(['name' => 'users.show']);

        $indexBO = Permission::create(['name' => 'branch_offices.index']);
        $createBO = Permission::create(['name' => 'branch_offices.store']);
        $updateBO = Permission::create(['name' => 'branch_offices.update']);
        $deleteBO = Permission::create(['name' => 'branch_offices.delete']);
        $showBO = Permission::create(['name' => 'branch_offices.show']);

        $admin = Role::findOrFail(1);
        $psycho = Role::findOrFail(2);
        $client = Role::findOrFail(3);

        $admin->syncPermissions([
            $test, $createUser, $updateUser, $deleteUser, $showUser, 
            $indexBO, $createBO, $updateBO, $deleteBO, $showBO, 
        ]);
        $psycho->syncPermissions([
            $test, $createUser, $showUser, 
            $indexBO, $showBO, 
        ]);
        $client->syncPermissions([
            $test, $showUser, 
            $indexBO, $showBO, 
        ]);
    }
}
