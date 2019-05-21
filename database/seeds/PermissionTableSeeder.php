<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',

            'user-list',
            'user-create',
            'user-edit',

            'course-list',
            'course-create',
            'course-edit',
            'course-delete',

            'courseConfiguration-list',
            'courseConfiguration-create',
            'courseConfiguration-edit',

            'systemConfiguration-backup',
            'systemConfiguration-list',
            'systemConfiguration-create',
            'systemConfiguration-edit',

            'coordinator-list',
            'coordinator-create',
            'coordinator-edit',

            'company-list',
            'company-create',
            'company-edit',

            'companySector-list',
            'companySector-create',
            'companySector-edit',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
