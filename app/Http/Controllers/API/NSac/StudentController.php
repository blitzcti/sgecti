<?php

namespace App\Http\Controllers\API\NSac;

use App\Http\Controllers\Controller;
use App\Models\NSac\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Search for a string in a specific array column
     *
     * @param $array array
     * @param $q string
     * @param $col string
     *
     * @return array
     */
    function search($array, $q, $col)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
        }, ARRAY_FILTER_USE_BOTH);
        $array = array_values($array);
        return $array;
    }

    public function get(Request $request)
    {
        if ((new Student())->isConnected()) {
            $students = Student::all()->sortBy('matricula');

            if (!empty($request->q)) {
                $students = $this->search($students->toArray(), $request->q, 'nome');
            }
        } else {
            $students = null;
        }

        return response()->json(
            $students,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByRA($ra)
    {
        if (!ctype_digit($ra)) {
            return response()->json(
                ['message' => 'Not integer'],
                401,
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'charset' => 'utf-8'
                ],
                JSON_UNESCAPED_UNICODE);
        }

        if ((new Student())->isConnected()) {
            $student = Student::all()->where('matricula', '=', $ra);
        } else {
            $student = null;
        }

        return response()->json(
            $student,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }
}
