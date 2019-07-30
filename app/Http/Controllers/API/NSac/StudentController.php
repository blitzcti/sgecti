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
            $students = array_values($students->toArray());

            if (!empty($request->q)) {
                $students = $this->search($students, $request->q, 'nome');
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
        if ((new Student())->isConnected()) {
            $student = Student::findOrFail($ra);
        } else {
            $student = null;
        }

        return response()->json(
            [$student],
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByYear($year)
    {
        if ((new Student())->isConnected()) {
            $year = substr($year, 2, 2);
            $students = Student::where('matricula', 'LIKE', "$year%")->get();
            $students = array_values($students->toArray());
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
}
