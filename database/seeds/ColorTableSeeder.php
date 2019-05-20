<?php

use App\Color;
use Illuminate\Database\Seeder;

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
        $color->save();

        $color = new Color();
        $color->name = 'purple';
        $color->save();

        $color = new Color();
        $color->name = 'red';
        $color->save();

        $color = new Color();
        $color->name = 'orange';
        $color->save();

        $color = new Color();
        $color->name = 'yellow';
        $color->save();

        $color = new Color();
        $color->name = 'green';
        $color->save();

        $color = new Color();
        $color->name = 'teal';
        $color->save();

        $color = new Color();
        $color->name = 'lime';
        $color->save();

        $color = new Color();
        $color->name = 'cyan';
        $color->save();

        $color = new Color();
        $color->name = 'aqua';
        $color->save();

        $color = new Color();
        $color->name = 'black';
        $color->save();
    }
}
