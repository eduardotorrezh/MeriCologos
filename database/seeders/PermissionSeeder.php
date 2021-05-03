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
        $createAdmin = Permission::create(['name' => 'admin.store']);
        $createDoc = Permission::create(['name' => 'doctor.store']);
        $createPatient = Permission::create(['name' => 'patient.store']);
        $updateUser = Permission::create(['name' => 'users.update']);
        $deleteUser = Permission::create(['name' => 'users.delete']);
        $showUser = Permission::create(['name' => 'users.show']);
        $indexAdmins = Permission::create(['name' => 'admins.index']);
        $indexPatients = Permission::create(['name' => 'patients.index']);
        $indexDoctors = Permission::create(['name' => 'doctors.index']);

        $indexBO = Permission::create(['name' => 'branch_offices.index']);
        $createBO = Permission::create(['name' => 'branch_offices.store']);
        $updateBO = Permission::create(['name' => 'branch_offices.update']);
        $deleteBO = Permission::create(['name' => 'branch_offices.delete']);
        $showBO = Permission::create(['name' => 'branch_offices.show']);

        $admin = Role::findOrFail(1);
        $doctor = Role::findOrFail(2);
        $patient = Role::findOrFail(3);

        $admin->syncPermissions([
            $test, $createAdmin, $createDoc, $createPatient, $updateUser, $deleteUser, $showUser, 
            $indexBO, $createBO, $updateBO, $deleteBO, $showBO, 
            $indexAdmins, $indexPatients, $indexDoctors 
        ]);

        $doctor->syncPermissions([
            $test, $createPatient, $showUser, $updateUser,
            $indexBO, $showBO, $indexPatients, $indexDoctors 
        ]);
        
        $patient->syncPermissions([
            $test, $showUser, $updateUser,
            $indexBO, $showBO, 
        ]);
    }
}