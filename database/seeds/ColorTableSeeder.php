<?php

use App\Color;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $color = new Color();
        $color->name = 'blue';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'purple';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'red';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'orange';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'yellow';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'green';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'teal';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'lime';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'cyan';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'aqua';
        $color->created_at = Carbon::now();
        $color->save();

        $color = new Color();
        $color->name = 'black';
        $color->created_at = Carbon::now();
        $color->save();
    }
}
