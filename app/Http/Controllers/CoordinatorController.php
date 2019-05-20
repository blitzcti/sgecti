<?php

namespace App\Http\Controllers;

use App\Coordinator;
use App\Course;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {

    }

    public function new()
    {
        $courses = Course::all();
        $users = User::all()->where('id_group', '=', 2);

        return view('admin.coordinator.new')->with(["courses"=> $courses,"users"=> $users]);
    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {
        $coordinator = new Coordinator();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'user' => 'required|numeric|min:1',
                'course' => 'required|numeric|min:1',
                'start' => 'required|date',
                'end' => 'date'
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $coordinator = Coordinator::all()->find($id);

                $coordinator->updated_at = Carbon::now();
            } else { // New
                $coordinator->created_at = Carbon::now();
            }

            $coordinator->id_user = $validatedData->user;
            $coordinator->id_course = $validatedData->course;
            $coordinator->vigencia_ini = $validatedData->start;
            $coordinator->vigencia_fim = $validatedData->end;

            $saved = $coordinator->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.coordenador.index')->with($params);
    }
}
