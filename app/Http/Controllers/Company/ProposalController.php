<?php

namespace App\Http\Controllers\Company;

use App\Http\Requests\Company\StoreProposal;
use App\Models\Proposal;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return view('company.proposal.new');
    }

    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('company.proposal.edit')->with(['proposal' => $proposal]);
    }

    public function store(StoreProposal $request)
    {
        $proposal = new Proposal();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova proposta";
        $log .= "\nUsuário (empresa): " . Auth::user()->name . "(" .  Auth::user()->company->name . ")";

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

            $proposal->schedule_2_id = $schedule2->id;
        }

        $proposal->company_id = Auth::user()->company->id;

        $proposal->schedule_id = $schedule->id;

        $proposal->deadline = $validatedData->deadline;
        $proposal->remuneration = $validatedData->remuneration;
        $proposal->description = $validatedData->description;
        $proposal->requirements = $validatedData->requirements;
        $proposal->benefits = $validatedData->benefits;
        $proposal->contact = $validatedData->contact;
        $proposal->type = $validatedData->type;
        $proposal->observation = $validatedData->observation;

        $saved = $proposal->save();
        $log .= "\nNovos dados: " . json_encode($proposal, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
            $proposal->createUser();
        } else {
            Log::error("Erro ao salvar proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('empresa.proposta.index')->with($params);
    }

    public function update($id, UpdateAgreement $request)
    {
//        $agreement = Agreement::all()->find($id);
//        $params = [];
//
//        $validatedData = (object)$request->validated();
//
//        $log = "Alteração de convênio";
//        $log .= "\nUsuário: " . Auth::user()->name;
//        $log .= "\nDados antigos: " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//
//        $agreement->start_date = $validatedData->startDate;
//        $agreement->end_date = ($validatedData->canceled) ? date("Y-m-d") : SystemConfiguration::getAgreementExpiration(Carbon::createFromFormat("Y-m-d", $agreement->start_date));;
//        $agreement->observation = $validatedData->observation;
//
//        $saved = $agreement->save();
//        $log .= "\nNovos dados: " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//
//        if ($saved) {
//            Log::info($log);
//        } else {
//            Log::error("Erro ao salvar convênio");
//        }
//
//        $params['saved'] = $saved;
//        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
//
//        return redirect()->route('coordenador.empresa.convenio.index')->with($params);
    }
}
