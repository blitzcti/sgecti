<?php

namespace App\Http\Controllers;

use App\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('course.index')->with(['courses' => $courses]);
    }

    public function new()
    {
        return view('course.new');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('curso.index');
        }

        $course = Course::findOrFail($id);
        $colors = [
            (object) ['id' => 'red', 'name' => 'Vermelho'],
            (object) ['id' => 'green', 'name' => 'Verde'],
            (object) ['id' => 'aqua', 'name' => 'Aqua'],
            (object) ['id' => 'purple', 'name' => 'Roxo'],
            (object) ['id' => 'blue', 'name' => 'Azul'],
            (object) ['id' => 'yellow', 'name' => 'Amarelo'],
            (object) ['id' => 'black', 'name' => 'Preto']
        ];

        return view('course.edit')->with(['course' => $course, 'colors' => $colors]);
    }

    public function save(Request $request)
    {
        $course = new Course();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate(
                [
                    'name' => 'required|max:30',
                    'color' => 'required|max:6',
                    'active' => 'required'
                ]);

            if ($request->exists('id')) {
                $id = $request->input('id');
                $course = Course::all()->find($id);

                $course->updated_at = Carbon::now();
            } else {
                $course->created_at = Carbon::now();
            }

            $course->name = $validatedData->name;
            $course->color = $validatedData->color;
            $course->active = $validatedData->active == 'true';

            $saved = $course->save();
            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('curso.index')->with($params);
    }
}
