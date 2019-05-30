<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ColorTableSeeder::class);
        $this->call(CourseTableSeeder::class);
        $this->call(SystemConfigurationTableSeeder::class);
        $this->call(BackupConfigurationTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}
