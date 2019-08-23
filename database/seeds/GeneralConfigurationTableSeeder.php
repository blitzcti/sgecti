<?php

use App\Models\GeneralConfiguration;
use Illuminate\Database\Seeder;

class GeneralConfigurationTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $config = new GeneralConfiguration();
        $config->max_years = 6;
        $config->min_year = 2;
        $config->min_semester = 1;
        $config->min_hours = 400;
        $config->min_months = 4;
        $config->min_months_ctps = 6;
        $config->min_grade = 7;
        $config->created_at = date_create('1970-01-01 00:00:00');
        $config->updated_at = date_create('1970-01-01 00:00:00');
        $config->save();
    }
}
