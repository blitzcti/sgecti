<?php

use App\Course;
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
        $course->id_color = 3;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Eletrotécnica';
        $course->id_color = 2;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Edificações';
        $course->id_color = 5;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Processamento de dados';
        $course->id_color = 11;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Eletrônica';
        $course->id_color = 6;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Decoração';
        $course->id_color = 10;
        $course->active = false;
        $course->created_at = Carbon::now();
        $course->save();

        $course = new Course();
        $course->name = 'Informática';
        $course->id_color = 1;
        $course->created_at = Carbon::now();
        $course->save();
    }
}
