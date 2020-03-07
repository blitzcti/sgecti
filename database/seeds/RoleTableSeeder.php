<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

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
            'friendly_name' => 'Administrador',
            'description' => 'Administra o sistema (root)',
        ]);

        $permissions = Permission::where('name', 'like', 'sysUsage')
            ->orWhere('name', 'like', 'db-%')
            ->orWhere('name', 'like', 'role-%')
            ->orWhere('name', 'like', 'user-%')
            ->orWhere('name', 'like', 'course-%')
            ->orWhere('name', 'like', 'courseConfiguration-%')
            ->orWhere('name', 'like', 'generalConfiguration-%')
            ->orWhere('name', 'like', 'systemConfiguration-%')
            ->orWhere('name', 'like', 'coordinator-%')
            ->orWhere('name', 'like', 'graduation-%')
            ->orWhere('name', 'like', 'student-%')
            ->get();
        $role->syncPermissions($permissions);

        $role = Role::create([
            'name' => 'teacher',
            'friendly_name' => 'Professor',
            'description' => 'Professor de uma disciplina técnica',
        ]);

        $role = Role::create([
            'name' => 'coordinator',
            'friendly_name' => 'Coordenador',
            'description' => 'Coordenador de uma disciplina técnica',
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
            'friendly_name' => 'Empresa',
            'description' => 'Empresas conveniadas com o colégio',
        ]);

        $permissions = Permission::where('name', 'like', 'proposal-%')
            ->get();
        $role->syncPermissions($permissions);

        $role = Role::create([
            'name' => 'student',
            'friendly_name' => 'Aluno',
            'description' => 'Alunos do NSac',
        ]);

        $permissions = Permission::where('name', 'like', 'proposal-list')
            ->orWhere('name', 'like', 'documents-%')
            ->get();
        $role->syncPermissions($permissions);
    }
}
