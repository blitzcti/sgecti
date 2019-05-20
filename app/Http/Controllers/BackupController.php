<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:systemConfiguration-backup');
    }

    public function index()
    {
        return view('admin.system.configurations.backup.index');
    }

    public function backup()
    {
        $data = json_encode($this->getData(), JSON_UNESCAPED_UNICODE);
        $fileName = 'backup.json';
        Storage::disk('local')->put($fileName, $data);
        return Storage::disk('local')->download($fileName);
    }

    public function restore(Request $request)
    {
        $params = [];
        if ($request->hasFile('json') && $request->file('json')->isValid()) {
            $data = file_get_contents($request->json);
            $data = json_decode($data, true);
            if ($this->verifyData($data)) {
                $data = (object)$data;
                Artisan::call('migrate:fresh');
                $this->restoreData($data);
            }
        }

        return redirect()->route('admin.configuracoes.backup.index')->with($params);
    }

    public function verifyInnerData($innerData, $class)
    {
        try {
            if (isset($innerData['id'])) {
                unset($innerData['id']);
            }

            new $class($innerData);
        } catch (Exception $e) {
            Log::info("Error in verify: " . $class);
            Log::info("Data: " . json_encode($innerData));
            Log::info("Error: " . $e->getMessage());
            return false;
        }

        return true;
    }

    public function verifyData($data)
    {
        if (is_array($data)) {
            if (array_key_exists('users', $data) &&
                array_key_exists('password_resets', $data) &&
                array_key_exists('colors', $data) &&
                array_key_exists('courses', $data) &&
                array_key_exists('course_configurations', $data) &&
                array_key_exists('coordinators', $data) &&
                array_key_exists('general_configurations', $data) &&
                array_key_exists('system_configurations', $data) &&
                array_key_exists('addresses', $data) &&
                array_key_exists('companies', $data) &&
                array_key_exists('sectors', $data) &&
                array_key_exists('supervisors', $data) &&
                array_key_exists('agreements', $data) &&
                array_key_exists('company_courses', $data) &&
                array_key_exists('permissions', $data) &&
                array_key_exists('roles', $data) &&
                array_key_exists('model_has_permissions', $data) &&
                array_key_exists('model_has_roles', $data) &&
                array_key_exists('role_has_permissions', $data)
            ) {
                if (is_array($data['users'])) {
                    foreach ($data['users'] as $model) {
                        if (!$this->verifyInnerData($model, "App\User")) {
                            return false;
                        }
                    }

                    foreach ($data['password_resets'] as $model) {
                        if (!$this->verifyInnerData($model, "App\PasswordReset")) {
                            return false;
                        }
                    }

                    foreach ($data['colors'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Color")) {
                            return false;
                        }
                    }

                    foreach ($data['courses'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Course")) {
                            return false;
                        }
                    }

                    foreach ($data['course_configurations'] as $model) {
                        if (!$this->verifyInnerData($model, "App\CourseConfiguration")) {
                            return false;
                        }
                    }

                    foreach ($data['coordinators'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Coordinator")) {
                            return false;
                        }
                    }

                    foreach ($data['general_configurations'] as $model) {
                        if (!$this->verifyInnerData($model, "App\GeneralConfiguration")) {
                            return false;
                        }
                    }

                    foreach ($data['system_configurations'] as $model) {
                        if (!$this->verifyInnerData($model, "App\SystemConfiguration")) {
                            return false;
                        }
                    }

                    foreach ($data['addresses'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Address")) {
                            return false;
                        }
                    }

                    foreach ($data['companies'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Company")) {
                            return false;
                        }
                    }

                    foreach ($data['sectors'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Sector")) {
                            return false;
                        }
                    }

                    foreach ($data['supervisors'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Supervisor")) {
                            return false;
                        }
                    }

                    foreach ($data['agreements'] as $model) {
                        if (!$this->verifyInnerData($model, "App\Agreement")) {
                            return false;
                        }
                    }

                    foreach ($data['company_courses'] as $model) {
                        if (!$this->verifyInnerData($model, "App\CompanyCourses")) {
                            return false;
                        }
                    }

                    foreach ($data['permissions'] as $model) {
                        if (!$this->verifyInnerData($model, "Spatie\Permission\Models\Permission")) {
                            return false;
                        }
                    }

                    foreach ($data['roles'] as $model) {
                        if (!$this->verifyInnerData($model, "Spatie\Permission\Models\Role")) {
                            return false;
                        }
                    }

                    foreach ($data['model_has_permissions'] as $model) {
                        if (!$this->verifyInnerData($model, "App\ModelHasPermission")) {
                            return false;
                        }
                    }

                    foreach ($data['model_has_roles'] as $model) {
                        if (!$this->verifyInnerData($model, "App\ModelHasRole")) {
                            return false;
                        }
                    }

                    foreach ($data['role_has_permissions'] as $model) {
                        if (!$this->verifyInnerData($model, "App\RoleHasPermission")) {
                            return false;
                        }
                    }
                }

                return true;
            }
        }

        return false;
    }

    public function getData()
    {
        $users = DB::table('users')->get()->sortBy('id');
        $password_resets = DB::table('password_resets')->get()->sortBy('id');
        $colors = DB::table('colors')->get()->sortBy('id');
        $courses = DB::table('courses')->get()->sortBy('id');
        $course_configurations = DB::table('course_configurations')->get()->sortBy('id');
        $coordinators = DB::table('coordinators')->get()->sortBy('id');
        $general_configurations = DB::table('general_configurations')->get()->sortBy('id');
        $system_configurations = DB::table('system_configurations')->get()->sortBy('id');
        $addresses = DB::table('addresses')->get()->sortBy('id');
        $companies = DB::table('companies')->get()->sortBy('id');
        $sectors = DB::table('sectors')->get()->sortBy('id');
        $supervisors = DB::table('supervisors')->get()->sortBy('id');
        $agreements = DB::table('agreements')->get()->sortBy('id');
        $company_courses = DB::table('company_courses')->get()->sortBy('id');

        $permissions = DB::table('permissions')->get()->sortBy('id');
        $roles = DB::table('roles')->get()->sortBy('id');
        $model_has_permissions = DB::table('model_has_permissions')->get();
        $model_has_roles = DB::table('model_has_roles')->get();
        $role_has_permissions = DB::table('role_has_permissions')->get();

        return [
            'users' => $users,
            'password_resets' => $password_resets,
            'colors' => $colors,
            'courses' => $courses,
            'course_configurations' => $course_configurations,
            'coordinators' => $coordinators,
            'general_configurations' => $general_configurations,
            'system_configurations' => $system_configurations,
            'addresses' => $addresses,
            'companies' => $companies,
            'sectors' => $sectors,
            'supervisors' => $supervisors,
            'agreements' => $agreements,
            'company_courses' => $company_courses,

            'permissions' => $permissions,
            'roles' => $roles,
            'model_has_permissions' => $model_has_permissions,
            'model_has_roles' => $model_has_roles,
            'role_has_permissions' => $role_has_permissions,
        ];
    }

    public function setAutoIncrement($tableName)
    {
        if (DB::connection()->getDriverName() == 'pgsql') {
            DB::statement('SELECT setval(\'' . $tableName . '_id_seq\', (SELECT MAX(id) FROM ' . $tableName . '));');
        } else if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET @m = (SELECT MAX(id) + 1 FROM ' . $tableName . '); ');
            DB::statement('SET @s = CONCAT(\'ALTER TABLE ' . $tableName . ' AUTO_INCREMENT=\', @m);');
            DB::statement('PREPARE stmt1 FROM @s;');
            DB::statement('EXECUTE stmt1;');
            DB::statement('DEALLOCATE PREPARE stmt1;');
        }
    }

    public function restoreData($data)
    {
        foreach ($data->users as $user) {
            DB::table('users')->insert($user);
            $this->setAutoIncrement('users');
        }

        foreach ($data->password_resets as $password_reset) {
            DB::table('password_resets')->insert($password_reset);
            $this->setAutoIncrement('password_resets');
        }

        foreach ($data->colors as $color) {
            DB::table('colors')->insert($color);
            $this->setAutoIncrement('colors');
        }

        foreach ($data->courses as $course) {
            DB::table('courses')->insert($course);
            $this->setAutoIncrement('courses');
        }

        foreach ($data->course_configurations as $course_configuration) {
            DB::table('course_configurations')->insert($course_configuration);
            $this->setAutoIncrement('course_configurations');
        }

        foreach ($data->coordinators as $coordinator) {
            DB::table('coordinators')->insert($coordinator);
            $this->setAutoIncrement('coordinators');
        }

        foreach ($data->general_configurations as $general_configuration) {
            DB::table('general_configurations')->insert($general_configuration);
            $this->setAutoIncrement('general_configurations');
        }

        foreach ($data->system_configurations as $system_configuration) {
            DB::table('system_configurations')->insert($system_configuration);
            $this->setAutoIncrement('system_configurations');
        }

        foreach ($data->addresses as $address) {
            DB::table('addresses')->insert($address);
            $this->setAutoIncrement('addresses');
        }

        foreach ($data->companies as $company) {
            DB::table('companies')->insert($company);
            $this->setAutoIncrement('companies');
        }

        foreach ($data->sectors as $sector) {
            DB::table('sectors')->insert($sector);
            $this->setAutoIncrement('sectors');
        }

        foreach ($data->supervisors as $supervisor) {
            DB::table('supervisors')->insert($supervisor);
            $this->setAutoIncrement('supervisors');
        }

        foreach ($data->agreements as $agreement) {
            DB::table('agreements')->insert($agreement);
            $this->setAutoIncrement('agreements');
        }

        foreach ($data->company_courses as $company_course) {
            DB::table('company_courses')->insert($company_course);
            $this->setAutoIncrement('company_courses');
        }

        foreach ($data->permissions as $permission) {
            DB::table('permissions')->insert($permission);
            $this->setAutoIncrement('permissions');
        }

        foreach ($data->roles as $role) {
            DB::table('roles')->insert($role);
            $this->setAutoIncrement('roles');
        }

        foreach ($data->model_has_permissions as $model_has_permission) {
            DB::table('model_has_permissions')->insert($model_has_permission);
        }

        foreach ($data->model_has_roles as $model_has_role) {
            DB::table('model_has_roles')->insert($model_has_role);
        }

        foreach ($data->role_has_permissions as $role_has_permission) {
            DB::table('role_has_permissions')->insert($role_has_permission);
        }
    }
}
