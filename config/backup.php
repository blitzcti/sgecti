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
        'users' => \App\Models\User::class,
        'password_resets' => \App\Models\PasswordReset::class,
        'permissions' => \App\Models\Permission::class,
        'roles' => \App\Models\Role::class,
        'model_has_permissions' => \App\Models\ManyToMany\ModelHasPermission::class,
        'model_has_roles' => \App\Models\ManyToMany\ModelHasRole::class,
        'role_has_permissions' => \App\Models\ManyToMany\RoleHasPermission::class,
        'colors' => \App\Models\Color::class,
        'system_configurations' => \App\Models\SystemConfiguration::class,
        'backup_configurations' => \App\Models\BackupConfiguration::class,
        'notifications' => \Illuminate\Notifications\DatabaseNotification::class,

        'general_configurations' => \App\Models\GeneralConfiguration::class,
        'courses' => \App\Models\Course::class,
        'course_configurations' => \App\Models\CourseConfiguration::class,
        'coordinators' => \App\Models\Coordinator::class,

        'addresses' => \App\Models\Address::class,
        'companies' => \App\Models\Company::class,
        'sectors' => \App\Models\Sector::class,
        'supervisors' => \App\Models\Supervisor::class,
        'agreements' => \App\Models\Agreement::class,
        'company_has_courses' => \App\Models\ManyToMany\CompanyCourse::class,
        'company_has_sectors' => \App\Models\ManyToMany\CompanySector::class,

        'schedules' => \App\Models\Schedule::class,
        'states' => \App\Models\State::class,
        'internships' => \App\Models\Internship::class,
        'amendments' => \App\Models\Amendment::class,

        'job_companies' => \App\Models\JobCompany::class,
        'jobs' => \App\Models\Job::class,

        'bimestral_reports' => \App\Models\BimestralReport::class,
        'final_reports' => \App\Models\FinalReport::class,

        'proposals' => \App\Models\Proposal::class,
        'proposal_has_courses' => \App\Models\ManyToMany\ProposalCourse::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tables to ignore
    |--------------------------------------------------------------------------
    |
    | This option controls the tables to ignore when doing backup.
    |
    */

    'sso_tables' => ['users', 'password_resets', 'roles', 'model_has_roles'],


];
