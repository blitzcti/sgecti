<?php

namespace App\Console;

use App\Models\BackupConfiguration;
use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDOException;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    private function isConnected() {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (!$this->isConnected()) {
            $backupConfig = new BackupConfiguration();
            if (Schema::hasTable($backupConfig->getTable())) {
                $backupConfig = BackupConfiguration::findOrFail(1);
                $days = $backupConfig->cronDays();
                $hour = $backupConfig->getHour();

                $schedule->call('App\Http\Controllers\BackupController@scheduledBackup')->days($days)->at($hour);
            }

            if (Schema::hasTable((new User())->getTable())
                && Schema::hasTable((new Coordinator())->getTable())
                && Schema::hasTable((new DatabaseNotification())->getTable())) {
                $schedule->call('App\Http\Controllers\CoordinatorController@checkCoordinators')->daily()->at('00:00');
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
