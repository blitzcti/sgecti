<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelJob;
use App\Http\Requests\StoreJob;
use App\Http\Requests\UpdateJob;
use App\Models\Company;
use App\Models\Job;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:job-list');
        $this->middleware('permission:job-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $jobs = Job::all()->filter(function ($job) use ($cIds) {
            return in_array($job->student->course_id, $cIds);
        });

        return view('coordinator.internship.job.index')->with(['jobs' => $jobs]);
    }

    public function create()
    {
        $companies = Company::all()->where('active', '=', true)->sortBy('id');
        $s = request()->s;

        return view('coordinator.internship.job.new')->with(
            ['companies' => $companies, 's' => $s]
        );
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

        $companies = Company::all()->where('active', '=', true)->sortBy('id');

        return view('coordinator.internship.job.edit')->with([
            'job' => $job, 'companies' => $companies,
        ]);
    }

    public function details($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $job = Job::findOrFail($id);
        if (!in_array($job->student->course_id, $cIds)) {
            abort(404);
        }

        return view('coordinator.internship.job.details')->with(['job' => $job]);
    }

    public function store(StoreJob $request)
    {
        $job = new Job();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo trabalho";
        $log .= "\nUsuário: " . Auth::user()->name;

        $job->ra = $validatedData->ra;
        $job->company_id = $validatedData->company;
        $job->sector_id = $validatedData->sector;
        $coordinator_id = Auth::user()->coordinators->where('course_id', '=', $job->student->course_id)->last()->id;
        $job->coordinator_id = $coordinator_id;
        $job->state_id = 1;
        $job->supervisor_id = $validatedData->supervisor;
        $job->start_date = $validatedData->startDate;
        $job->end_date = $validatedData->endDate;
        $job->protocol = $validatedData->protocol;
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

        return redirect()->route('coordenador.estagio.trabalho.index')->with($params);
    }

    public function update($id, UpdateJob $request)
    {
        $job = Job::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de trabalho";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($job, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $job->ra = $validatedData->ra;
        $job->company_id = $validatedData->company;
        $job->sector_id = $validatedData->sector;
        $coordinator_id = Auth::user()->coordinators->where('course_id', '=', $job->student->course_id)->last()->id;
        $job->coordinator_id = $coordinator_id;
        $job->supervisor_id = $validatedData->supervisor;
        $job->start_date = $validatedData->startDate;
        $job->end_date = $validatedData->endDate;
        $job->protocol = $validatedData->protocol;
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

        return redirect()->route('coordenador.estagio.trabalho.index')->with($params);
    }

    public function cancel($id, CancelJob $request)
    {
        $job = Job::findOrFail($id);
        $validatedData = (object)$request->validated();

        $job->state_id = 3;
        $job->reason_to_cancel = $validatedData->reasonToCancel;
        $saved = $job->save();

        $log = "Cancelamento de trabalho";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nAluno com trabalho cancelado: " . $job->student->nome;

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao cancelar trabalho");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.estagio.trabalho.index')->with($params);
    }
}
