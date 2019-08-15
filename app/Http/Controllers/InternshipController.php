<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelInternship;
use App\Http\Requests\StoreInternship;
use App\Http\Requests\UpdateInternship;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InternshipController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:internship-list');
        $this->middleware('permission:internship-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:internship-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internships = Internship::all()->filter(function ($internship) use ($cIds) {
            return in_array($internship->student->course_id, $cIds);
        });

        return view('coordinator.internship.index')->with(['internships' => $internships]);
    }

    public function create()
    {
        $companies = Company::all()->where('active', '=', true)->sortBy('id');
        $s = request()->s;

        return view('coordinator.internship.new')->with(
            ['companies' => $companies, 's' => $s]
        );
    }

    public function edit($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internship = Internship::findOrFail($id);
        if (!in_array($internship->student->course_id, $cIds)) {
            abort(404);
        }

        $companies = Company::all()->where('active', '=', true)->sortBy('id');

        return view('coordinator.internship.edit')->with([
            'internship' => $internship, 'companies' => $companies,
        ]);
    }

    public function details($id)
    {
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        $internship = Internship::findOrFail($id);
        if (!in_array($internship->student->course_id, $cIds)) {
            abort(404);
        }

        return view('coordinator.internship.details')->with(['internship' => $internship]);
    }

    public function store(StoreInternship $request)
    {
        $internship = new Internship();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo estágio";
        $log .= "\nUsuário: " . Auth::user()->name;

        $schedule = new Schedule();

        $schedule->mon_s = $validatedData->monS;
        $schedule->mon_e = $validatedData->monE;
        $schedule->tue_s = $validatedData->tueS;
        $schedule->tue_e = $validatedData->tueE;
        $schedule->wed_s = $validatedData->wedS;
        $schedule->wed_e = $validatedData->wedE;
        $schedule->thu_s = $validatedData->thuS;
        $schedule->thu_e = $validatedData->thuE;
        $schedule->fri_s = $validatedData->friS;
        $schedule->fri_e = $validatedData->friE;
        $schedule->sat_s = $validatedData->satS;
        $schedule->sat_e = $validatedData->satE;
        $saved = $schedule->save();

        if ($validatedData->has2Turnos) {
            $schedule2 = new Schedule();

            $schedule2->mon_s = $validatedData->monS2;
            $schedule2->mon_e = $validatedData->monE2;
            $schedule2->tue_s = $validatedData->tueS2;
            $schedule2->tue_e = $validatedData->tueE2;
            $schedule2->wed_s = $validatedData->wedS2;
            $schedule2->wed_e = $validatedData->wedE2;
            $schedule2->thu_s = $validatedData->thuS2;
            $schedule2->thu_e = $validatedData->thuE2;
            $schedule2->fri_s = $validatedData->friS2;
            $schedule2->fri_e = $validatedData->friE2;
            $schedule2->sat_s = $validatedData->satS2;
            $schedule2->sat_e = $validatedData->satE2;
            $saved = $schedule2->save();

            $internship->schedule_2_id = $schedule2->id;
        }

        $internship->ra = $validatedData->ra;
        $internship->company_id = $validatedData->company;
        $internship->sector_id = $validatedData->sector;
        $coordinator_id = Auth::user()->coordinators->where('course_id', '=', $internship->student->course_id)->last()->id;
        $internship->coordinator_id = $coordinator_id;
        $internship->schedule_id = $schedule->id;
        $internship->state_id = 1;
        $internship->supervisor_id = $validatedData->supervisor;
        $internship->start_date = $validatedData->startDate;
        $internship->end_date = $validatedData->endDate;
        $internship->protocol = $validatedData->protocol;
        $internship->activities = $validatedData->activities;
        $internship->observation = $validatedData->observation;
        $internship->active = $validatedData->active;

        $saved = $internship->save();
        $log .= "\nNovos dados: " . json_encode($internship, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.estagio.index')->with($params);
    }

    public function update($id, UpdateInternship $request)
    {
        $internship = Internship::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($internship, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $schedule = $internship->schedule;

        $schedule->mon_s = $validatedData->monS;
        $schedule->mon_e = $validatedData->monE;
        $schedule->tue_s = $validatedData->tueS;
        $schedule->tue_e = $validatedData->tueE;
        $schedule->wed_s = $validatedData->wedS;
        $schedule->wed_e = $validatedData->wedE;
        $schedule->thu_s = $validatedData->thuS;
        $schedule->thu_e = $validatedData->thuE;
        $schedule->fri_s = $validatedData->friS;
        $schedule->fri_e = $validatedData->friE;
        $schedule->sat_s = $validatedData->satS;
        $schedule->sat_e = $validatedData->satE;
        $saved = $schedule->save();

        if ($validatedData->has2Turnos) {
            $schedule2 = $internship->schedule2 ?? new Schedule();

            $schedule2->mon_s = $validatedData->monS2;
            $schedule2->mon_e = $validatedData->monE2;
            $schedule2->tue_s = $validatedData->tueS2;
            $schedule2->tue_e = $validatedData->tueE2;
            $schedule2->wed_s = $validatedData->wedS2;
            $schedule2->wed_e = $validatedData->wedE2;
            $schedule2->thu_s = $validatedData->thuS2;
            $schedule2->thu_e = $validatedData->thuE2;
            $schedule2->fri_s = $validatedData->friS2;
            $schedule2->fri_e = $validatedData->friE2;
            $schedule2->sat_s = $validatedData->satS2;
            $schedule2->sat_e = $validatedData->satE2;
            $saved = $schedule2->save();

            $internship->schedule_2_id = $schedule2->id;
        } else {
            $internship->schedule_2_id = null;
        }

        $internship->ra = $validatedData->ra;
        $internship->company_id = $validatedData->company;
        $internship->sector_id = $validatedData->sector;
        $coordinator_id = Auth::user()->coordinators->where('course_id', '=', $internship->student->course_id)->last()->id;
        $internship->coordinator_id = $coordinator_id;
        $internship->supervisor_id = $validatedData->supervisor;
        $internship->start_date = $validatedData->startDate;
        $internship->end_date = $validatedData->endDate;
        $internship->protocol = $validatedData->protocol;
        $internship->activities = $validatedData->activities;
        $internship->observation = $validatedData->observation;
        $internship->active = $validatedData->active;

        $saved = $internship->save();
        $log .= "\nNovos dados: " . json_encode($internship, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.estagio.index')->with($params);
    }

    public function cancel($id, CancelInternship $request)
    {
        $internship = Internship::findOrFail($id);
        $validatedData = (object)$request->validated();

        $internship->state_id = 3;
        $internship->reason_to_cancel = $validatedData->reasonToCancel;
        $saved = $internship->save();

        $log = "Cancelamento de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nAluno com estágio cancelado: " . $internship->student->nome;

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao cancelar estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.estagio.index')->with($params);
    }
}
