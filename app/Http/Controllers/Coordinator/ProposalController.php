<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\ApproveProposal;
use App\Http\Requests\Coordinator\DeleteProposal;
use App\Http\Requests\Coordinator\RejectProposal;
use App\Http\Requests\Coordinator\StoreProposal;
use App\Http\Requests\Coordinator\UpdateProposal;
use App\Models\Company;
use App\Models\Course;
use App\Models\Proposal;
use App\Models\Schedule;
use App\Notifications\WebNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:proposal-list');
        $this->middleware('permission:proposal-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:proposal-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $cIds = Auth::user()->coordinator_courses_id;
        $proposals = Proposal::all()->filter(function ($proposal) use ($cIds) {
            $ret = false;
            foreach ($proposal->courses as $course) {
                if (!$ret) {
                    $ret = in_array($course->id, $cIds);
                }
            }

            return $ret;
        });

        return view('coordinator.proposal.index')->with(['proposals' => $proposals]);
    }

    public function show($id)
    {
        $proposal = Proposal::findOrFail($id);

        return view('coordinator.proposal.details')->with(['proposal' => $proposal]);
    }

    public function create()
    {
        $companies = Company::all()->where('active', '=', true)->sortBy('id');
        $courses = Course::all()->where('active', '=', true)->sortBy('id');

        return view('coordinator.proposal.new')->with(['companies' => $companies, 'courses' => $courses]);
    }

    public function edit($id)
    {
        $proposal = Proposal::findOrFail($id);
        $companies = Company::all()->where('active', '=', true)->sortBy('id');
        $courses = Course::all()->where('active', '=', true)->sortBy('id');

        return view('coordinator.proposal.edit')->with(['proposal' => $proposal, 'companies' => $companies, 'courses' => $courses]);
    }

    public function store(StoreProposal $request)
    {
        $proposal = new Proposal();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;

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

        $proposal->company_id = $validatedData->company;
        $proposal->deadline = $validatedData->deadline;
        $proposal->remuneration = $validatedData->remuneration;
        $proposal->description = $validatedData->description;
        $proposal->requirements = $validatedData->requirements;
        $proposal->benefits = $validatedData->benefits;
        $proposal->contact = $validatedData->contact;
        $proposal->type = $validatedData->type;
        $proposal->approved_at = Carbon::now();
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

        return redirect()->route('coordenador.proposta.index')->with($params);
    }

    public function update($id, UpdateProposal $request)
    {
        $proposal = Proposal::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;
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

        $proposal->deadline = $validatedData->deadline;
        $proposal->remuneration = $validatedData->remuneration;
        $proposal->description = $validatedData->description;
        $proposal->requirements = $validatedData->requirements;
        $proposal->benefits = $validatedData->benefits;
        $proposal->contact = $validatedData->contact;
        $proposal->type = $validatedData->type;
        $proposal->approved_at = Carbon::now();
        $proposal->observation = $validatedData->observation;
        $proposal->reason_to_reject = null;

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

        return redirect()->route('coordenador.proposta.index')->with($params);
    }

    public function approve($id, ApproveProposal $request)
    {
        $proposal = Proposal::findOrFail($id);

        $validatedData = (object)$request->validated();

        $log = "Aprovação de proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nProposta aprovada: " . $proposal->id;

        $proposal->approved_at = Carbon::now();

        $saved = $proposal->save();

        if ($saved) {
            Log::info($log);

            $cName = Auth::user()->coordinator_courses_name;
            $notification = new WebNotification([
                'description' => "Proposta de estágio",
                'text' => "O coordenador de {$cName} aprovou sua proposta de estágio.",
                'icon' => 'bullhorn',
                'url' => route('empresa.proposta.detalhes', ['id' => $proposal->id]),
            ]);

            $user = $proposal->company->user;
            $user->notify($notification);
        } else {
            Log::error("Erro ao aprovar proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Aprovada com sucesso' : 'Erro ao aprovar!';

        if (isset($validatedData->redirectTo) && $validatedData->redirectTo != null) {
            return redirect()->route($validatedData->redirectTo)->with($params);
        }

        return redirect()->route('coordenador.proposta.index')->with($params);
    }

    public function reject($id, RejectProposal $request)
    {
        $proposal = Proposal::findOrFail($id);

        $validatedData = (object)$request->validated();

        $log = "Rejeição de proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nProposta rejeitada: " . $proposal->id;

        $proposal->reason_to_reject = $validatedData->reasonToReject;

        $saved = $proposal->save();

        if ($saved) {
            Log::info($log);

            $cName = Auth::user()->coordinator_courses_name;
            $notification = new WebNotification([
                'description' => "Proposta de estágio",
                'text' => "O coordenador de {$cName} rejeitou sua proposta de estágio. Clique para mais detalhes.",
                'icon' => 'bullhorn',
                'url' => route('empresa.proposta.detalhes', ['id' => $proposal->id]),
            ]);

            $user = $proposal->company->user;
            $user->notify($notification);
        } else {
            Log::error("Erro ao rejeitar proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Rejeitada com sucesso' : 'Erro ao rejeitar!';

        if (isset($validatedData->redirectTo) && $validatedData->redirectTo != null) {
            return redirect()->route($validatedData->redirectTo)->with($params);
        }

        return redirect()->route('coordenador.proposta.index')->with($params);
    }

    public function destroy($id, DeleteProposal $request)
    {
        $proposal = Proposal::findOrFail($id);

        $validatedData = (object)$request->validated();

        $log = "Exclusão de proposta de estágio";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nProposta excluída: " . $proposal->id;

        $saved = $proposal->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir proposta de estágio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';

        if (isset($validatedData->redirectTo) && $validatedData->redirectTo != null) {
            return redirect()->route($validatedData->redirectTo)->with($params);
        }

        return redirect()->route('coordenador.proposta.index')->with($params);
    }
}
