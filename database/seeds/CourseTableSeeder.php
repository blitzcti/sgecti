<?php

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = new Course();
        $course->name = 'Mecânica';
        $course->color_id = 3;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Eletrotécnica';
        $course->color_id = 2;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Edificações';
        $course->color_id = 5;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Processamento de dados';
        $course->color_id = 11;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Eletrônica';
        $course->color_id = 6;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Decoração';
        $course->color_id = 10;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Informática';
        $course->color_id = 1;
        $course->created_at = Carbon::now();
        $course->save();
    }
}
