<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'sysUsage',

            'db-backup',
            'db-restore',

            'role-list',
            'role-create',
            'role-edit',
            //'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            //'user-delete',

            'course-list',
            'course-create',
            'course-edit',
            //'course-delete',

            'courseConfiguration-list',
            'courseConfiguration-create',
            'courseConfiguration-edit',
            //'courseConfiguration-delete',

            'generalConfiguration-list',
            'generalConfiguration-create',
            'generalConfiguration-edit',
            //'systemConfiguration-delete',

            'systemConfiguration-list',
            'systemConfiguration-create',
            'systemConfiguration-edit',
            //'systemConfiguration-delete',

            'coordinator-list',
            'coordinator-create',
            'coordinator-edit',
            //'coordinator-delete',

            'graduation-list',

            'company-list',
            'company-create',
            'company-edit',
            //'company-delete',

            'companySector-list',
            'companySector-create',
            'companySector-edit',
            //'companySector-delete',

            'companyAgreement-list',
            'companyAgreement-create',
            'companyAgreement-edit',
            //'companyAgreement-delete',

            'companySupervisor-list',
            'companySupervisor-create',
            'companySupervisor-edit',
            //'companySupervisor-delete',

            'internship-list',
            'internship-create',
            'internship-edit',
            //'internship-delete',

            'internshipAmendment-list',
            'internshipAmendment-create',
            'internshipAmendment-edit',
            //'internshipAmendment-delete',

            'jobCompany-list',
            'jobCompany-create',
            'jobCompany-edit',
            //'jobCompany-delete',

            'job-list',
            'job-create',
            'job-edit',
            //'job-delete',

            'report-list',
            'report-create',
            'report-edit',
            //'report-delete',

            'proposal-list',
            'proposal-create',
            'proposal-edit',
            'proposal-delete',

            'student-list',

            'documents-list',
        ];


        foreach ($permissions as $permission) {
            $p = new Permission();
            $p->name = $permission;
            $p->guard_name = 'web';
            $p->save();
        }
    }
}
