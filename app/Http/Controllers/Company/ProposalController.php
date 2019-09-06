<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreProposal;
use App\Http\Requests\Company\UpdateProposal;
use App\Models\Course;
use App\Models\ManyToMany\ProposalCourse;
use App\Models\Proposal;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('company');
        $this->middleware('permission:proposal-list');
        $this->middleware('permission:proposal-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:proposal-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $proposals = Auth::user()->company->proposals;

        return view('company.proposal.index')->with(['proposals' => $proposals]);
    }

    public function create()
    {
        $courses = Course::all()->where('active', '=', true)->sortBy('id');

        return view('company.proposal.new')->with(['courses' => $courses]);
    }

    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        $courses = Course::all()->where('active', '=', true)->sortBy('id');

        return view('company.proposal.edit')->with(['proposal' => $proposal, 'courses' => $courses]);
    }

    public function store(StoreProposal $request)
    {
        $proposal = new Proposal();
        $proposalCourse = new ProposalCourse();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova proposta de estágio";
        $log .= "\nUsuário (empresa): " . Auth::user()->name . "(" . Auth::user()->company->name . ")";

        if ($validatedData->hasSchedule) {
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

            $proposal->schedule_id = $schedule->id;

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

                $proposal->schedule_2_id = $schedule2->id;
            }
        }

        $proposal->company_id = Auth::user()->company->id;
        $proposal->deadline = $validatedData->deadline;
        $proposal->remuneration = $validatedData->remuneration;
        $proposal->description = $validatedData->description;
        $proposal->requirements = $validatedData->requirements;
        $proposal->benefits = $validatedData->benefits;
        $proposal->contact = $validatedData->contact;
        $proposal->type = $validatedData->type;
        $proposal->observation = $validatedData->observation;

        $saved = $proposal->save();

        $proposal->syncCourses(array_map('intval', $validatedData->courses));

        $log .= "\nNovos dados: " . json_encode($proposal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('empresa.proposta.index')->with($params);
    }

    public function update($id, UpdateProposal $request)
    {
        $proposal = Proposal::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de proposta de estágio";
        $log .= "\nUsuário (empresa): " . Auth::user()->name . "(" . Auth::user()->company->name . ")";
        $log .= "\nDados antigos: " . json_encode($proposal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($validatedData->hasSchedule) {
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

            $proposal->schedule_id = $schedule->id;

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

                $proposal->schedule_2_id = $schedule2->id;
            } else {
                $proposal->schedule_2_id = null;
            }
        } else {
            $proposal->schedule_id = null;
        }

        $proposal->company_id = Auth::user()->company->id;
        $proposal->deadline = $validatedData->deadline;
        $proposal->remuneration = $validatedData->remuneration;
        $proposal->description = $validatedData->description;
        $proposal->requirements = $validatedData->requirements;
        $proposal->benefits = $validatedData->benefits;
        $proposal->contact = $validatedData->contact;
        $proposal->type = $validatedData->type;
        $proposal->observation = $validatedData->observation;

        $saved = $proposal->save();

        $proposal->syncCourses(array_map('intval', $validatedData->courses));

        $log .= "\nNovos dados: " . json_encode($proposal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('empresa.proposta.index')->with($params);
    }
}
