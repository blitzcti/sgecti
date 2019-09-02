<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'admin',
            'friendlyName' => 'Administrador',
            'description' => 'Administra o sistema (root)'
        ]);

        $permissions = Permission::where('name', 'like', 'sysUsage')
            ->orWhere('name', 'like', 'role-%')
            ->orWhere('name', 'like', 'user-%')
            ->orWhere('name', 'like', 'course-%')
            ->orWhere('name', 'like', 'courseConfiguration-%')
            ->orWhere('name', 'like', 'systemConfiguration-%')
            ->orWhere('name', 'like', 'coordinator-%')
            ->get();
        $role->syncPermissions($permissions);

        $role = Role::create([
            'name' => 'teacher',
            'friendlyName' => 'Professor',
            'description' => 'Professor de uma disciplina técnica'
        ]);

        $permissions = Permission::where('name', 'like', 'company-%')
            ->orWhere('name', 'like', 'companySector-%')
            ->orWhere('name', 'like', 'companyAgreement-%')
            ->orWhere('name', 'like', 'companySupervisor-%')
            ->orWhere('name', 'like', 'internship-%')
            ->orWhere('name', 'like', 'internshipAmendment-%')
            ->orWhere('name', 'like', 'jobCompany-%')
            ->orWhere('name', 'like', 'job-%')
            ->orWhere('name', 'like', 'report-%')
            ->orWhere('name', 'like', 'proposal-%')
            ->orWhere('name', 'like', 'student-%')
            ->get();
        $role->syncPermissions($permissions);

        $role = Role::create([
            'name' => 'company',
            'friendlyName' => 'Empresa',
            'description' => 'Empresas conveniadas com o colégio'
        ]);

        $permissions = Permission::where('name', 'like', 'proposal-%')
            ->get();
        $role->syncPermissions($permissions);
    }
}
