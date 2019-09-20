<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\DeleteProposal;
use App\Http\Requests\Company\StoreProposal;
use App\Http\Requests\Company\UpdateProposal;
use App\Models\Proposal;
use App\Models\Schedule;
use App\Notifications\CoordinatorNotification;
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
        $company = Auth::user()->company;
        $proposals = $company->proposals;

        return view('company.proposal.index')->with(['proposals' => $proposals]);
    }

    public function show($id)
    {
        $company = Auth::user()->company;
        $proposal = $company->proposals()->findOrFail($id);

        return view('company.proposal.details')->with(['proposal' => $proposal]);
    }

    public function create()
    {
        $company = Auth::user()->company;
        $courses = $company->courses->where('active', '=', true)->sortBy('id');

        return view('company.proposal.new')->with(['courses' => $courses]);
    }

    public function edit($id)
    {
        $company = Auth::user()->company;
        $proposal = $company->proposals()->findOrFail($id);
        $courses = $company->courses->where('active', '=', true)->sortBy('id');

        return view('company.proposal.edit')->with(['proposal' => $proposal, 'courses' => $courses]);
    }

    public function store(StoreProposal $request)
    {
        $proposal = new Proposal();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name . " (" . Auth::user()->company->name . ")";

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
            $company = Auth::user()->company;
            $notification = new CoordinatorNotification([
                'description' => "Proposta de estágio",
                'text' => "A empresa $company->name acabou de enviar uma nova proposta de estágio.",
                'icon' => 'bullhorn',
                'url' => route('coordenador.proposta.detalhes', ['id' => $proposal->id]),
            ]);

            foreach ($proposal->courses as $course) {
                $course->coordinator()->user->notify($notification);
            }
        } else {
            Log::error("Erro ao salvar proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('empresa.proposta.index')->with($params);
    }

    public function update($id, UpdateProposal $request)
    {
        $company = Auth::user()->company;
        $proposal = $company->proposals()->findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name . " (" . Auth::user()->company->name . ")";
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

    public function destroy($id, DeleteProposal $request)
    {
        $company = Auth::user()->company;
        $proposal = $company->proposals()->findOrFail($id);

        $validatedData = (object)$request->validated();

        $log = "Exclusão de proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name . " (" . Auth::user()->company->name . ")";
        $log .= "\nProposta excluída: " . $proposal->id;

        $saved = $proposal->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';

        return redirect()->route('empresa.proposta.index')->with($params);
    }
}
