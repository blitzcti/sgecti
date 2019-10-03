<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class LogController extends Controller
{
    public function clearLogs()
    {
        $this->generateZip();
        $fileName = Carbon::now()->toDateTimeString() . '.zip';
        $f = fopen(storage_path("app/backups/logs.zip"), "r+");

        try {
            Storage::disk('sftp')->put("logs/$fileName", $f);
            Log::info("Logs enviados para o servidor.\nNome: {$fileName}");
        } catch (Exception $e) {
            Log::error("Erro ao enviar os logs para o servidor: {$e->getMessage()}");
        }
    }

    private function generateZip()
    {
        $zip = new ZipArchive();
        $file = storage_path("app/backups/logs.zip");

        $logs = array_diff(scandir(storage_path('logs/')), ['.', '..', '.gitignore']);

        if ($zip->open($file, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($logs as $log) {
                $zip->addFile(storage_path("logs/$log"), $log);
            }

            $zip->close();
        }

        foreach ($logs as $log) {
            unlink(storage_path("logs/$log"));
        }
    }
}
