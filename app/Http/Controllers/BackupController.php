<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    private $tables = [
        'users' => "App\Models\User",
        'password_resets' => "App\Models\PasswordReset",
        'colors' => "App\Models\Color",
        'courses' => "App\Models\Course",
        'course_configurations' => "App\Models\CourseConfiguration",
        'coordinators' => "App\Models\Coordinator",
        'general_configurations' => "App\Models\GeneralConfiguration",
        'system_configurations' => "App\Models\SystemConfiguration",
        'addresses' => "App\Models\Address",
        'companies' => "App\Models\Company",
        'sectors' => "App\Models\Sector",
        'supervisors' => "App\Models\Supervisor",
        'agreements' => "App\Models\Agreement",
        'company_courses' => "App\Models\CompanyCourses",
        'permissions' => "Spatie\Permission\Models\Permission",
        'roles' => "Spatie\Permission\Models\Role",
        'model_has_permissions' => "App\Models\ModelHasPermission",
        'model_has_roles' => "App\Models\ModelHasRole",
        'role_has_permissions' => "App\Models\RoleHasPermission",
    ];

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
        $data = json_encode($this->getData(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $fileName = Carbon::now()->toDateTimeString() . '.json';
        return response()->streamDownload(function () use ($data) {
            echo $data;
        }, $fileName);
    }

    public function restore(Request $request)
    {
        $params = [];
        if ($request->hasFile('json') && $request->file('json')->isValid()) {
            $data = file_get_contents($request->json);
            $data = json_decode($data, true);
            if ($this->verifyData($data)) {
                try {
                    $data = (object)$data;
                    Artisan::call('migrate:fresh');

                    $this->restoreData($data);

                    $params["saved"] = true;
                    $params["message"] = "Backup restaurado!";
                } catch (Exception $e) {
                    Artisan::call('migrate:fresh', ['seed']);

                    $params["saved"] = false;
                    $params["message"] = "Ocorreu um erro ao restaurar o backup! Reiniciando banco de dados...";
                }
            } else {
                $params["saved"] = false;
                $params["message"] = "Arquivo de backup inválido.";
            }
        }

        return redirect()->route('admin.configuracoes.backup.index')->with($params);
    }

    public function verifyInnerData($data, $class)
    {
        try {
            foreach ($data as $innerData) {
                if (isset($innerData['id'])) {
                    unset($innerData['id']);
                }

                new $class($innerData);
            }
        } catch (Exception $e) {
            Log::error("Error in verify: {$class}");
            Log::info("  Data: " . json_encode($data));
            Log::info("  Error: {$e->getMessage()}");
            throw new Exception("Error in verify.");
        }

        return true;
    }

    public function verifyData($data)
    {
        if (is_array($data)) {
            try {
                foreach ($this->tables as $table => $class) {
                    $innerData = $data[$table];
                    $this->verifyInnerData($innerData, $class);
                }

                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }

    public function getData()
    {
        $data = [];
        foreach ($this->tables as $table => $class) {
            if ((new $class)->getKeyName() != null) {
                $data[$table] = DB::table($table)->get();
            } else {
                $data[$table] = DB::table($table)->get()->sortBy('id');
            }

            $data[$table] = array_values($data[$table]->toArray());
        }

        return $data;
    }

    public function setAutoIncrement($tableName)
    {
        $primaryKey = (new $this->tables[$tableName])->getKeyName();

        if (DB::connection()->getDriverName() == 'pgsql') {
            DB::statement("SELECT setval('{$tableName}_id_seq', (SELECT MAX({$primaryKey}) FROM {$tableName}));");
        } else if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement("SET @m = (SELECT MAX({$primaryKey}) + 1 FROM {$tableName}); ");
            DB::statement("SET @s = CONCAT('ALTER TABLE {$tableName} AUTO_INCREMENT=', @m);");
            DB::statement('PREPARE stmt1 FROM @s;');
            DB::statement('EXECUTE stmt1;');
            DB::statement('DEALLOCATE PREPARE stmt1;');
        }
    }

    public function restoreData($data)
    {
        foreach ($this->tables as $table => $class) {
            foreach ($data->{$table} as $innerData) {
                DB::table($table)->insert($innerData);
            }

            if ((new $class)->getKeyName() != null) {
                $this->setAutoIncrement($table);
            }
        }
    }
}
