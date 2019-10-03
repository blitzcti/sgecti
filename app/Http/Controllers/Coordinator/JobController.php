<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\CancelJob;
use App\Http\Requests\Coordinator\DestroyJob;
use App\Http\Requests\Coordinator\ReactivateJob;
use App\Http\Requests\Coordinator\StoreJob;
use App\Http\Requests\Coordinator\UpdateJob;
use App\Models\Job;
use App\Models\JobCompany;
use App\Models\State;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:job-list');
        $this->middleware('permission:job-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:job-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $jobs = Job::all()->filter(function ($job) use ($cIds) {
            return in_array($job->student->course_id, $cIds);
        });

        return view('coordinator.job.index')->with(['jobs' => $jobs]);
    }

    public function create()
    {
        $companies = JobCompany::all()->where('active', '=', true)->sortBy('id');
        $s = request()->s;

        return view('coordinator.job.new')->with([
            'companies' => $companies, 's' => $s
        ]);
    }

    public function edit($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $job = Job::findOrFail($id);
        if (!in_array($job->student->course_id, $cIds)) {
            abort(404);
        }

        $companies = JobCompany::all()->where('active', '=', true)->merge([$job->company])->sortBy('id');

        return view('coordinator.job.edit')->with([
            'job' => $job, 'companies' => $companies,
        ]);
    }

    public function show($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $job = Job::findOrFail($id);
        if (!in_array($job->student->course_id, $cIds)) {
            abort(404);
        }

        return view('coordinator.job.details')->with(['job' => $job]);
    }

    public function store(StoreJob $request)
    {
        $job = new Job();
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Novo trabalho";
        $log .= "\nUsuário: {$user->name}";

        $job->ra = $validatedData->ra;
        $job->company_id = $validatedData->company;

        $coordinator = Auth::user()->coordinators->where('course_id', '=', $job->student->course_id)->last();
        $coordinator_id = $coordinator->temporary_of->id ?? $coordinator->id;
        $job->coordinator_id = $coordinator_id;

        $job->state_id = State::FINISHED;
        $job->start_date = $validatedData->startDate;
        $job->end_date = $validatedData->endDate;
        $job->protocol = $validatedData->protocol;
        $job->activities = $validatedData->activities;
        $job->observation = $validatedData->observation;
        $job->active = $validatedData->active;
        $job->ctps = $validatedData->ctps;

        $saved = $job->save();
        $log .= "\nNovos dados: " . json_encode($job, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar trabalho");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.trabalho.index')->with($params);
    }

    public function update($id, UpdateJob $request)
    {
        $job = Job::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Alteração de trabalho";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($job, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $job->start_date = $validatedData->startDate;
        $job->end_date = $validatedData->endDate;
        $job->protocol = $validatedData->protocol;
        $job->activities = $validatedData->activities;
        $job->observation = $validatedData->observation;
        $job->active = $validatedData->active;
        $job->ctps = $validatedData->ctps;

        $saved = $job->save();
        $log .= "\nNovos dados: " . json_encode($job, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar trabalho");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.trabalho.index')->with($params);
    }

    public function destroy($id, DestroyJob $request)
    {
        $job = Job::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Exclusão de trabalho";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($job, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $job->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir trabalho");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';
        return redirect()->route('coordenador.trabalho.index')->with($params);
    }

    public function cancel($id, CancelJob $request)
    {
        $job = Job::findOrFail($id);
        $validatedData = (object)$request->validated();

        $job->state_id = State::CANCELED;
        $job->reason_to_cancel = $validatedData->reasonToCancel;
        $job->canceled_at = $validatedData->canceledAt;
        $saved = $job->save();

        $user = Auth::user();
        $log = "Cancelamento de trabalho";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nAluno com trabalho cancelado: " . $job->student->nome;

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao cancelar trabalho");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.trabalho.index')->with($params);
    }

    public function reactivate($id, ReactivateJob $request)
    {
        $job = Job::findOrFail($id);
        $validatedData = (object)$request->validated();

        $job->state_id = State::FINISHED;
        $job->reason_to_cancel = null;
        $job->canceled_at = null;
        $saved = $job->save();

        $user = Auth::user();
        $log = "Reativamento de trabalho";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nAluno com trabalho reativado: " . $job->student->nome;

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao reativar trabalho");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.trabalho.index')->with($params);
    }
}
