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
use ZipArchive;

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
        if (config('backup.zip')) {
            $this->generateZip();
            $fileName = Carbon::now()->toDateTimeString() . '.zip';
            Log::info("Solicitação de backup.");
            return response()->download(storage_path("app/backups/backup.zip"), $fileName);
        } else {
            $this->generateJson();
            $fileName = Carbon::now()->toDateTimeString() . '.json';
            Log::info("Solicitação de backup.");
            return response()->download(storage_path("app/backups/backup.json"), $fileName);
        }
    }

    public function restore(Request $request)
    {
        ini_set("memory_limit", "1G");

        $params = [];
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            if ($request->file->extension() === "zip") {
                $zip = new ZipArchive();
                Storage::disk('local')->put('backups/uploaded/backup.zip', file_get_contents($request->file));
                if ($zip->open(storage_path("app/backups/uploaded/backup.zip"))) {
                    $dir = storage_path("app/backups/uploaded/");

                    if ($this->verifyZipFile($zip)) {
                        try {
                            $zip->extractTo(storage_path("app/backups/uploaded/"));
                            $zip->close();
                            set_time_limit(300);
                            Artisan::call('migrate:fresh');

                            $this->restoreDataFromZip($dir);

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
                        $zip->close();
                        $params["saved"] = false;
                        $params["message"] = "Arquivo de backup inválido.";
                        Log::warning("Arquivo de backup inválido.");
                    }
                }

                Storage::disk('local')->delete(array_diff(Storage::disk('local')->files('backups/uploaded/'), ['backups/uploaded/.gitignore']));
            } else if ($request->file->extension() === "txt") {
                $file = $request->file;
                $data = file_get_contents($file);
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
            } else {
                $params["saved"] = false;
                $params["message"] = "Arquivo de backup inválido.";
                Log::warning("Arquivo de backup inválido.");
            }
        }

        return redirect()->route('admin.configuracao.backup.index')->with($params);
    }

    public function scheduledBackup()
    {
        Log::info("Backup agendado iniciado.");
        if (config('backup.zip')) {
            $this->generateZip();
            $fileName = Carbon::now()->toDateTimeString() . '.zip';
            $data = file_get_contents(storage_path("app/backups/backup.zip"));
        } else {
            $this->generateJson();
            $fileName = Carbon::now()->toDateTimeString() . '.json';
            $data = file_get_contents(storage_path("app/backups/backup.json"));
        }

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
        return redirect()->route('admin.configuracao.backup.index')->with($params);
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

    private function verifyZipFile(ZipArchive $zipFile)
    {
        try {
            foreach ($this->tables as $table => $class) {
                $content = $zipFile->getFromName("$table.json");
                if (!$content) {
                    return false;
                }

                $content = json_decode($content, true);

                $this->verifyInnerData($content, $class);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function generateZip()
    {
        $this->getData(true);

        $zip = new ZipArchive();
        $file = storage_path("app/backups/backup.zip");

        if ($zip->open($file, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($this->tables as $table => $class) {
                $zip->addFile(storage_path("app/backups/zip/$table.json"), "$table.json");
            }

            $zip->close();
        }

        Storage::disk('local')->delete(array_diff(Storage::disk('local')->files('backups/zip'), ['backups/zip/.gitignore']));
    }

    private function generateJson()
    {
        $data = json_encode($this->getData(false), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $file = storage_path("app/backups/backup.json");
        file_put_contents($file, $data);
    }

    private function getData($toFile = false)
    {
        if ($toFile) {
            $dir = storage_path("app/backups/zip");
            foreach ($this->tables as $table => $class) {
                $f = fopen("$dir/$table.json", "w+");
                $data = $this->getTableData($table, $class);
                fwrite($f, json_encode($data, JSON_UNESCAPED_UNICODE));
                fclose($f);
            }
        } else {
            $data = [];
            foreach ($this->tables as $table => $class) {
                $data[$table] = $this->getTableData($table, $class);
            }

            return $data;
        }
    }

    private function getTableData($table, $class)
    {
        if ((new $class)->getKeyName() != null) {
            $data = DB::table($table)->get()->sortBy((new $class)->getKeyName());
        } else {
            $data = DB::table($table)->get();
        }

        return array_values($data->toArray());
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

            if ((new $class)->getKeyName() != null && (new $class)->incrementing) {
                $this->setAutoIncrement($table);
            }
        }
    }

    private function restoreDataFromZip($dir)
    {
        foreach ($this->tables as $table => $class) {
            $data = (object)json_decode(file_get_contents("$dir/$table.json"), true);

            foreach ($data as $innerData) {
                DB::table($table)->insert($innerData);
            }

            if ((new $class)->getKeyName() != null && (new $class)->incrementing) {
                $this->setAutoIncrement($table);
            }
        }
    }
}
