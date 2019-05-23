<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:coordinator-list');
        $this->middleware('permission:coordinator-create', ['only' => ['new', 'save']]);
        $this->middleware('permission:coordinator-edit', ['only' => ['edit', 'save']]);
    }

    public function index()
    {
        $coordinators = Coordinator::all();

        return view('admin.coordinator.index')->with(['coordinators' => $coordinators]);
    }

    public function new()
    {
        $courses = Course::all();
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", "teacher");
        })->get();

        return view('admin.coordinator.new')->with(["courses" => $courses, "users" => $users]);
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('admin.coordinator.index');
        }

        $coordinator = Coordinator::findOrFail($id);
        $users = User::all();
        $courses = Course::all();

        return view('admin.coordinator.edit')->with(['coordinator' => $coordinator, 'users' => $users, 'courses' => $courses]);
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
