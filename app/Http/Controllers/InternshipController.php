<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CTPS;
use App\Models\Internship;
use App\Models\Schedule;
use App\Models\State;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InternshipController extends Controller
{
    public function index()
    {
        $internships = Internship::all();
        return view('coordinator.internship.index')->with(['internships' => $internships]);
    }

    public function new()
    {
        $companies = Company::all()->where('ativo', '=', true);
        $states = State::all();
        $supervisors = Supervisor::all();

        return view('coordinator.internship.new')->with(
            ['companies' => $companies, 'states' => $states, 'supervisors' => $supervisors]
        );
    }

    public function edit($id)
    {
        $internship = Internship::findOrFail($id);
        $companies = Company::all()->where('ativo', '=', true);
        $states = State::all();

        return view('coordinator.internship.edit')->with([
            'internship' => $internship, 'companies' => $companies, 'states' => $states
        ]);
    }

    public function save(Request $request)
    {
        $internship = new Internship();
        $schedule = new Schedule();
        $params = [];

        if (!$request->exists('cancel')) {
            $boolData = (object)$request->validate([
                'hasCTPS' => 'required|boolean'
            ]);

            $validatedData = (object)$request->validate([
                'ra' => 'required|numeric|min:1',
                'active' => 'required|numeric|min:1',
                'company' => 'required|min:1',
                'sector' => 'required|min:1',
                'start' => 'date|required',
                'end' => 'date|required',
                'activities' => 'required|max:6000',

                'seg_e' => 'nullable|date_format:H:i',
                'seg_s' => 'nullable|date_format:H:i',
                'ter_e' => 'nullable|date_format:H:i',
                'ter_s' => 'nullable|date_format:H:i',
                'qua_e' => 'nullable|date_format:H:i',
                'qua_s' => 'nullable|date_format:H:i',
                'qui_e' => 'nullable|date_format:H:i',
                'qui_s' => 'nullable|date_format:H:i',
                'sex_e' => 'nullable|date_format:H:i',
                'sex_s' => 'nullable|date_format:H:i',
                'sab_e' => 'nullable|date_format:H:i',
                'sab_s' => 'nullable|date_format:H:i',

                'supervisor' => 'required|numeric|min:1',

                'state' => 'required|max:1',
                'protocol' => 'required|max:5',
                'observation' => 'max:200',
                'reason_to_cancel' => 'max:2000',

                'ctps' => (($boolData->hasCTPS) ? 'required|numeric|min:11' : ''),
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');

                $internship = Internship::all()->find($id);
                $internship->updated_at = Carbon::now();

                $schedule = $internship->schedule;
                $schedule->updated_at = Carbon::now();

                if ($boolData->hasCTPS) {
                    $internship = $validatedData->ctps;
                }

                $log = "Alteração de estágio";
                $log .= "\nDados antigos: " . json_encode($internship, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else { // New
                $internship->created_at = Carbon::now();

                $schedule->created_at = Carbon::now();

                $log = "Novo estágio";
            }

            $log .= "\nUsuário: " . Auth::user()->name;

            //Tem CTPS
            if ($boolData->hasCTPS) {
                $internship->ctps = $validatedData->ctps;
            }

            $schedule->seg_e = $validatedData->seg_e;
            $schedule->seg_s = $validatedData->seg_s;
            $schedule->ter_e = $validatedData->ter_e;
            $schedule->ter_s = $validatedData->ter_s;
            $schedule->qua_e = $validatedData->qua_e;
            $schedule->qua_s = $validatedData->qua_s;
            $schedule->qui_e = $validatedData->qui_e;
            $schedule->qui_s = $validatedData->qui_s;
            $schedule->sex_e = $validatedData->sex_e;
            $schedule->sex_s = $validatedData->sex_s;
            $schedule->sab_e = $validatedData->sab_e;
            $schedule->sab_s = $validatedData->sab_s;
            $saved = $schedule->save();

            $internship->ra = $validatedData->ra;
            $internship->company_id = $validatedData->company;
            $internship->sector_id = $validatedData->sector;
            $internship->coordinator_id = Auth::user()->coordinator()->id;
            $internship->schedule_id = $schedule->id;
            $internship->state_id = $validatedData->state;
            $internship->supervisor_id = $validatedData->supervisor;
            $internship->data_ini = $validatedData->start;
            $internship->data_fim = $validatedData->end;
            $internship->protocolo = $validatedData->protocol;
            $internship->atividades = $validatedData->activities;
            $internship->observacao = $validatedData->observation;
            $internship->motivo_cancelamento = $validatedData->reason_to_cancel;
            $internship->ativo = $validatedData->active;

            $log .= "\nNovos dados: " . json_encode($internship, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $saved = $internship->save();

            if ($saved) {
                Log::info($log);
            } else {
                Log::error("Erro ao salvar estágio");
            }

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('coordenador.estagio.index')->with($params);
    }
}
