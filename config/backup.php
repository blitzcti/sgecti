<?php

return [

    'zip' => true,


    /*
    |--------------------------------------------------------------------------
    | Tables to backup
    |--------------------------------------------------------------------------
    |
    | This option controls the tables to make backup and which model they use.
    |
    */

    'tables' => [
        'users' => "App\Models\User",
        'password_resets' => "App\Models\PasswordReset",
        'permissions' => "Spatie\Permission\Models\Permission",
        'roles' => "Spatie\Permission\Models\Role",
        'model_has_permissions' => "App\Models\ManyToMany\ModelHasPermission",
        'model_has_roles' => "App\Models\ManyToMany\ModelHasRole",
        'role_has_permissions' => "App\Models\ManyToMany\RoleHasPermission",
        'colors' => "App\Models\Color",
        'system_configurations' => "App\Models\SystemConfiguration",
        'backup_configurations' => "App\Models\BackupConfiguration",
        'notifications' => "Illuminate\Notifications\DatabaseNotification",

        'general_configurations' => "App\Models\GeneralConfiguration",
        'courses' => "App\Models\Course",
        'course_configurations' => "App\Models\CourseConfiguration",
        'coordinators' => "App\Models\Coordinator",

        'addresses' => "App\Models\Address",
        'companies' => "App\Models\Company",
        'sectors' => "App\Models\Sector",
        'supervisors' => "App\Models\Supervisor",
        'agreements' => "App\Models\Agreement",
        'company_courses' => "App\Models\ManyToMany\CompanyCourse",
        'company_sectors' => "App\Models\ManyToMany\CompanySector",

        'schedules' => "App\Models\Schedule",
        'states' => "App\Models\State",
        'internships' => "App\Models\Internship",
        'jobs' => "App\Models\Job",
        'amendments' => "App\Models\Amendment",

        'bimestral_reports' => "App\Models\BimestralReport",
        'final_reports' => "App\Models\FinalReport",

        'proposals' => "App\Models\Proposal",
        'proposal_courses' => "App\Models\ManyToMany\ProposalCourse",
    ],


];
