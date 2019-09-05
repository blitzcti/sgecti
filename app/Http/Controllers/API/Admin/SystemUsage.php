<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SystemUsage extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sysUsage');
    }

    private function linuxCPUUsage()
    {
        if (is_readable("/proc/stat")) {
            $stats = @file_get_contents("/proc/stat");
            if ($stats !== false) {
                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);
                for ($i = 0; $i < sizeof($stats); $i++) {
                    $s = explode(" ", $stats[$i]);
                    if ($s[0] == "cpu") {
                        $s = array_slice($s, 1);
                        $stats = $s;
                        break;
                    }
                }

                return $stats;
            }
        }

        return null;
    }

    private function cpuUsage()
    {
        $load = null;

        if (stristr(PHP_OS, "win")) {
            $cmd = "wmic cpu get loadpercentage /all";
            @exec($cmd, $output);

            if ($output) {
                foreach ($output as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $load = $line;
                        break;
                    }
                }
            }
        } else {
            $stats0 = $this->linuxCPUUsage();
            sleep(1);
            $stats1 = $this->linuxCPUUsage();

            if (!is_null($stats0) && !is_null($stats1)) {
                $stats = $stats1;
                for ($i = 0; $i < sizeof($stats); $i++) {
                    $stats[$i] = $stats1[$i] - $stats0[$i];
                }

                foreach ($stats as $s) {
                    $load += $s;
                }

                $load = 100 - ($stats[3] * 100) / $load;
            }
        }

        return $load;
    }

    function memoryUsage()
    {
        $memoryTotal = null;
        $memoryFree = null;

        if (stristr(PHP_OS, "win")) {
            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
            @exec($cmd, $outputTotalPhysicalMemory);

            $cmd = "wmic OS get FreePhysicalMemory";
            @exec($cmd, $outputFreePhysicalMemory);

            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                foreach ($outputTotalPhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryTotal = $line;
                        break;
                    }
                }

                foreach ($outputFreePhysicalMemory as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        $memoryFree = $line;
                        $memoryFree *= 1024;
                        break;
                    }
                }
            }
        } else {
            if (is_readable("/proc/meminfo")) {
                $stats = @file_get_contents("/proc/meminfo");

                if ($stats !== false) {
                    $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                    $stats = explode("\n", $stats);

                    foreach ($stats as $statLine) {
                        $statLineData = explode(":", trim($statLine));

                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                            $memoryTotal = trim($statLineData[1]);
                            $memoryTotal = explode(" ", $memoryTotal);
                            $memoryTotal = $memoryTotal[0];
                            $memoryTotal *= 1024;
                        }

                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                            $memoryFree = trim($statLineData[1]);
                            $memoryFree = explode(" ", $memoryFree);
                            $memoryFree = $memoryFree[0];
                            $memoryFree *= 1024;
                        }
                    }
                }
            }
        }

        if (is_null($memoryTotal) || is_null($memoryFree)) {
            return null;
        } else {
            return [
                'free' => $memoryFree,
                'total' => $memoryTotal,
            ];
        }
    }

    private function diskUsage()
    {
        $dir = base_path();
        return [
            'free' => disk_free_space($dir),
            'total' => disk_total_space($dir),
        ];
    }

    private function maintenance()
    {
        $isDown = app()->isDownForMaintenance();
        $ret = [
            'isDown' => $isDown,
        ];

        if ($isDown) {
            $allowed = (object)json_decode(file_get_contents(storage_path("framework/down")), true);
            $ret['allowed'] = $allowed->allowed;
        }

        return $ret;
    }

    public function index()
    {
        return response()->json(
            [
                'cpu' => $this->cpuUsage(),
                'memory' => $this->memoryUsage(),
                'disk' => $this->diskUsage(),
                'maintenance' => $this->maintenance(),
            ],
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function down(Request $request)
    {
        $allow = ['127.0.0.1', '::1'];
        if (!in_array($request->getClientIp(), $allow)) {
            array_push($allow, $request->getClientIp());
        }

        Artisan::call('down', ['--allow' => $allow]);
    }

    public function up()
    {
        Artisan::call('up');
    }
}
