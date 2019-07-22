<?php

namespace App\Http\Controllers;

use App\Models\BackupConfiguration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    private $tables;

    function __construct()
    {
        $this->middleware('permission:systemConfiguration-backup');
        $this->tables = Config::get('backup.tables');
    }

    public function index()
    {
        $backupConfig = BackupConfiguration::findOrFail(1);
        $days = $backupConfig->days();
        $hour = $backupConfig->getHour();
        return view('admin.system.configurations.backup.index')->with(['days' => $days, 'hour' => $hour]);
    }

    public function backup()
    {
        $data = json_encode($this->getData(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $fileName = Carbon::now()->toDateTimeString() . '.json';
        Log::info("Solicitação de backup.");
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
                    set_time_limit(300);
                    Artisan::call('migrate:fresh');

                    $this->restoreData($data);

                    $params["saved"] = true;
                    $params["message"] = "Backup restaurado!";
                    Log::info("Backup restaurado!");
                } catch (Exception $e) {
                    Log::error("Erro ao restaurar do arquivo de backup: {$e}");
                    Artisan::call('cache:forget', ['key' => 'spatie.permission.cache']);
                    Artisan::call('config:cache');
                    Artisan::call('migrate:fresh', ['--seed' => true]);
                    Log::info("Banco de dados reiniciado.");

                    $params["saved"] = false;
                    $params["message"] = "Ocorreu um erro ao restaurar o backup! Banco de dados reiniciado.";
                }
            } else {
                $params["saved"] = false;
                $params["message"] = "Arquivo de backup inválido.";
                Log::warning("Arquivo de backup inválido.");
            }
        }

        return redirect()->route('admin.configuracoes.backup.index')->with($params);
    }

    public function scheduledBackup()
    {
        Log::info("Backup agendado iniciado.");
        $data = json_encode($this->getData(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $fileName = Carbon::now()->toDateTimeString() . '.json';
        try {
            Storage::disk('sftp')->put($fileName, $data);
            Log::info("Arquivo de backup enviado para o servidor.\nNome: {$fileName}");
        } catch (Exception $e) {
            Log::error("Erro ao enviar o arquivo de backup para o servidor: {$e->getMessage()}");
        }
    }

    public function storeConfig(Request $request)
    {
        $params = [];
        $saved = false;

        $validatedData = (object)$request->validate([
            'days' => 'required|array',
            'hour' => 'required|date_format:H:i'
        ]);

        $backupConfig = BackupConfiguration::findOrFail(1);

        $allDays = [
            'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday',
        ];

        foreach ($allDays as $day) {
            $backupConfig->{$day} = in_array($day, $validatedData->days);
        }
        $backupConfig->hour = $validatedData->hour;

        $saved = $backupConfig->save();

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar configurações!';
        return redirect()->route('admin.configuracoes.backup.index')->with($params);
    }

    private function verifyInnerData($data, $class)
    {
        try {
            foreach ($data as $innerData) {
                if (isset($innerData['id'])) {
                    unset($innerData['id']);
                }

                new $class($innerData);
            }
        } catch (Exception $e) {
            throw new Exception("Error in verify.");
        }

        return true;
    }

    private function verifyData($data)
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

    private function getData()
    {
        $data = [];
        foreach ($this->tables as $table => $class) {
            if ((new $class)->getKeyName() != null) {
                $data[$table] = DB::table($table)->get()->sortBy((new $class)->getKeyName());
            } else {
                $data[$table] = DB::table($table)->get();
            }

            $data[$table] = array_values($data[$table]->toArray());
        }

        return $data;
    }

    private function setAutoIncrement($tableName)
    {
        $primaryKey = (new $this->tables[$tableName])->getKeyName();

        if (DB::connection()->getDriverName() == 'pgsql') {
            DB::statement("SELECT setval('{$tableName}_{$primaryKey}_seq', (SELECT MAX({$primaryKey}) FROM {$tableName}));");
        } else if (DB::connection()->getDriverName() == 'mysql') {
            $max = DB::table($tableName)->max($primaryKey) + 1;
            DB::statement("ALTER TABLE {$tableName} AUTO_INCREMENT={$max}");
        }
    }

    private function restoreData($data)
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
