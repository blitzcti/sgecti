<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\CancelJob;
use App\Http\Requests\Coordinator\DestroyJob;
use App\Http\Requests\Coordinator\ReactivateJob;
use App\Http\Requests\Coordinator\StoreJob;
use App\Http\Requests\Coordinator\UpdateJob;
use App\Models\Course;
use App\Models\Job;
use App\Models\JobCompany;
use App\Models\State;
use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PDF;

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
        $courses = Auth::user()->coordinator_of;

        $jobs = Job::all()->filter(function (Job $job) use ($courses) {
            return $courses->contains($job->student->course);
        });

        return view('coordinator.job.index')->with(['jobs' => $jobs]);
    }

    public function create()
    {
        $companies = JobCompany::actives()->orderBy('id')->get();
        $s = request()->s;

        return view('coordinator.job.new')->with([
            'companies' => $companies, 's' => $s
        ]);
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        if (!Auth::user()->coordinator_of->contains($job->student->course)) {
            abort(404);
        }

        $companies = JobCompany::getActives()->merge([$job->company])->sortBy('id');

        return view('coordinator.job.edit')->with([
            'job' => $job, 'companies' => $companies,
        ]);
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
        if (!Auth::user()->coordinator_of->contains($job->student->course)) {
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
        $job->sector_id = $validatedData->sector;

        $course = $job->student->course;

        $job->state_id = State::FINISHED;
        $job->start_date = $validatedData->startDate;
        $job->end_date = $validatedData->endDate;
        $job->plan_date = $validatedData->planDate;
        $job->protocol = $validatedData->protocol;
        $job->approval_number = $this->generateApprovalNumber($course);
        $job->activities = $validatedData->activities;
        $job->observation = $validatedData->observation;
        $job->active = $validatedData->active;
        $job->ctps = $validatedData->ctps;

        $coordinator = Auth::user()->coordinators->where('course_id', '=', $course->id)->last();
        $coordinator_id = $coordinator->temporary_of->id ?? $coordinator->id;
        $job->coordinator_id = $coordinator_id;

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

        $job->sector_id = $validatedData->sector;
        $job->plan_date = $validatedData->planDate;
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

    public function pdf($id)
    {
        ini_set('max_execution_time', 300);

        $job = Job::findOrFail($id);
        $student = $job->student;
        $sysConfig = SystemConfiguration::getCurrent();

        $data = [
            'job' => $job,
            'student' => $student,
            'sysConfig' => $sysConfig,
        ];

        $pdf = PDF::loadView('pdf.report.job', $data);
        $pdf->getDomPDF()->setHttpContext(stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'Cookie: ' . implode("; ", array_map(
                        function ($k, $v) {
                            return "{$k}={$v}";
                        },
                        array_keys($_COOKIE),
                        array_values($_COOKIE)
                    )),
            ],
        ]));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('relatorioFinal.pdf');
    }

    private function generateApprovalNumber(Course $course)
    {
        $no = 1;
        $year = Carbon::now()->year;

        $jobs = Job::whereYear('date', '=', $year)->get();

        foreach ($jobs as $job) {
            if ($job->student->course_id == $course->id) {
                $no++;
            }
        }

        while (strlen($no) < 3) {
            $no = "0{$no}";
        }
        return "{$no}/{$year}";
    }
}
