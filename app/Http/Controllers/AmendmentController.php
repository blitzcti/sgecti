<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAmendment;
use App\Http\Requests\UpdateAmendment;
use App\Models\Amendment;
use App\Models\Internship;
use App\Models\Schedule;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AmendmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:internshipAmendment-list');
        $this->middleware('permission:internshipAmendment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:internshipAmendment-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_courses_id;

        $amendments = Amendment::all()->filter(function ($amendment) use ($cIds) {
            return in_array($amendment->internship->student->course_id, $cIds);
        });

        return view('coordinator.internship.amendment.index')->with(['amendments' => $amendments]);
    }

    public function indexByInternship($id)
    {
        $internship = Internship::findOrFail($id);
        $amendments = $internship->amendments;

        return view('coordinator.internship.amendment.index')->with(['amendments' => $amendments, 'internship' => $internship]);
    }

    public function create()
    {
        $cIds = Auth::user()->coordinator_courses_id;

        $internships = State::findOrFail(1)->internships->filter(function ($internship) use ($cIds) {
            return in_array($internship->student->course_id, $cIds);
        })->where('active', '=', true)->sortBy('id');

        $i = request()->i;
        return view('coordinator.internship.amendment.new')->with(['internships' => $internships, 'i' => $i]);
    }

    public function edit($id)
    {
        $amendment = Amendment::findOrFail($id);
        return view('coordinator.internship.amendment.edit')->with(['amendment' => $amendment]);
    }

    public function store(StoreAmendment $request)
    {
        $amendment = new Amendment();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo termo aditivo";
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

        if ($validatedData->has2Schedules) {
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

            $amendment->schedule_2_id = $schedule2->id;
        }

        $amendment->internship_id = $validatedData->internship;
        $amendment->schedule_id = $schedule->id;
        $amendment->start_date = $validatedData->startDate;
        $amendment->end_date = $validatedData->endDate;
        $amendment->new_end_date = $validatedData->newEndDate;
        $amendment->protocol = $validatedData->protocol;
        $amendment->observation = $validatedData->observation;

        $saved = $amendment->save();
        $log .= "\nNovos dados: " . json_encode($amendment, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar termo aditivo");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.estagio.aditivo.index')->with($params);
    }

    public function update($id, UpdateAmendment $request)
    {
        $amendment = Amendment::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de termo aditivo";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($amendment, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $schedule = $amendment->schedule;

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

        if ($validatedData->has2Schedules) {
            $schedule2 = $amendment->schedule2 ?? new Schedule();

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

            $amendment->schedule_2_id = $schedule2->id;
        } else {
            $amendment->schedule_2_id = null;
        }

        $amendment->start_date = $validatedData->startDate;
        $amendment->end_date = $validatedData->endDate;
        $amendment->new_end_date = $validatedData->newEndDate;
        $amendment->protocol = $validatedData->protocol;
        $amendment->observation = $validatedData->observation;

        $saved = $amendment->save();
        $log .= "\nNovos dados: " . json_encode($amendment, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar termo aditivo");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.estagio.aditivo.index')->with($params);
    }
}
