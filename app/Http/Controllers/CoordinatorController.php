<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

                $log = "Alteração de coordenador";
                $log .= "\nDados antigos: " . json_encode($coordinator, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else { // New
                $coordinator->created_at = Carbon::now();

                $log = "Novo coordenador";
            }

            $log .= "\nUsuário: " . Auth::user()->name;

            $coordinator->user_id = $validatedData->user;
            $coordinator->course_id = $validatedData->course;
            $coordinator->vigencia_ini = $validatedData->start;
            $coordinator->vigencia_fim = $validatedData->end;

            $log .= "\nNovos dados: " . json_encode($coordinator, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $saved = $coordinator->save();
            if ($saved) {
                Log::info($log);
            } else {
                Log::error("Erro ao salvar coordenador");
            }

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.coordenador.index')->with($params);
    }
}
