<?php

use App\Models\BackupConfiguration;
use Illuminate\Database\Seeder;

class BackupConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $backupConfig = new BackupConfiguration();
        $backupConfig->save();
    }
}
