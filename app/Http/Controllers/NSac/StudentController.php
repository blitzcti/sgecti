<?php

namespace App\Http\Controllers\NSac;

use App\Http\Controllers\Controller;
use App\Models\NSac\Student;

class StudentController extends Controller
{
    public function getAjax()
    {
        if ((new Student())->isConnected()) {
            $students = Student::all()->sortBy('matricula');
        } else {
            $students = null;
        }

        return response()->json(
            ['students' => $students],
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }
}
