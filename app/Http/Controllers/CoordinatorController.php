<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCoordinator;
use App\Http\Requests\UpdateCoordinator;
use App\Models\Coordinator;
use App\Models\Course;
use App\Models\User;
use App\Notifications\CoordinatorNotification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CoordinatorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:coordinator-list');
        $this->middleware('permission:coordinator-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:coordinator-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $coordinators = Coordinator::all();

        return view('admin.coordinator.index')->with(['coordinators' => $coordinators]);
    }

    public function indexByCourse($id)
    {
        $course = Course::findOrFail($id);
        $coordinators = $course->coordinators;

        return view('admin.coordinator.index')->with(['coordinators' => $coordinators, 'course' => $course]);
    }

    public function create()
    {
        $courses = Course::all()->sortBy('id');
        $users = User::whereHas("roles", function ($q) {
            $q->where("name", "teacher");
        })->get();

        $c = request()->c;

        return view('admin.coordinator.new')->with(["courses" => $courses, "users" => $users, 'c' => $c]);
    }

    public function edit($id)
    {
        $coordinator = Coordinator::findOrFail($id);
        $users = User::all()->sortBy('id');
        $courses = Course::all()->sortBy('id');

        return view('admin.coordinator.edit')->with(['coordinator' => $coordinator, 'users' => $users, 'courses' => $courses]);
    }

    public function store(StoreCoordinator $request)
    {
        $coordinator = new Coordinator();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo coordenador";
        $log .= "\nUsuário: " . Auth::user()->name;

        $coordinator->created_at = Carbon::now();
        $coordinator->user_id = $validatedData->user;
        $coordinator->course_id = $validatedData->course;
        $coordinator->start_date = $validatedData->startDate;
        $coordinator->end_date = $validatedData->endDate;

        $saved = $coordinator->save();
        $log .= "\nNovos dados: " . json_encode($coordinator, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
            $cName = $coordinator->course->name;
            $notification = new CoordinatorNotification(['description' => "Coordenadoria de $cName", 'text' => "Você agora é coordenador de $cName.", 'icon' => 'black-tie']);
            $coordinator->user->notify($notification);
        } else {
            Log::error("Erro ao salvar coordenador");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.coordenador.index')->with($params);
    }

    public function update($id, UpdateCoordinator $request)
    {
        $coordinator = Coordinator::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $coordinator->updated_at = Carbon::now();

        $log = "Alteração de coordenador";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($coordinator, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $coordinator->user_id = $validatedData->user;
        $coordinator->course_id = $validatedData->course;
        $coordinator->start_date = $validatedData->startDate;
        $coordinator->end_date = $validatedData->endDate;

        $saved = $coordinator->save();
        $log .= "\nNovos dados: " . json_encode($coordinator, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);

            $cName = $coordinator->course->name;
            $user = Auth::user();
            $endDate = ($coordinator->end_date != null) ? date("d/m/Y", strtotime($coordinator->end_date)) : 'Indeterminado';
            $notification = new CoordinatorNotification(['description' => "Coordenadoria de $cName", 'text' => "O usuário $user->name alterou sua data de vigência para $endDate.", 'icon' => 'black-tie']);
            $coordinator->user->notify($notification);
        } else {
            Log::error("Erro ao salvar coordenador");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.coordenador.index')->with($params);
    }

    public function checkCoordinators()
    {
        $coordinators = Coordinator::expiredToday();
        foreach ($coordinators as $coordinator) {
            $cName = $coordinator->course->name;
            $notification = new CoordinatorNotification(['description' => "Coordenadoria de $cName", 'text' => "Seu cargo de coordenador expirou.", 'icon' => 'calendar']);
            $coordinator->user->notify($notification);
        }

        $coordinators = Coordinator::actives();
        foreach ($coordinators as $coordinator) {
            $endDate = new DateTime($coordinator->end_date);
            $max = Carbon::now()->modify('-30 day');
            if ($endDate < $max) {
                $period = $max->diff($endDate)->format("%a");
                $cName = $coordinator->course->name;
                $notification = new CoordinatorNotification(['description' => "Coordenadoria de $cName", 'text' => "Seu cargo de coordenador expira em $period dias.", 'icon' => 'calendar']);
                $coordinator->user->notify($notification);
            }
        }
    }
}
