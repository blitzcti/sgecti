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

    public function edit()
    {

    }

    public function save(Request $request)
    {
        $internship = new Internship();
        $ctps = new CTPS();
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

                'seg_e' => 'date_format:H:i',
                'seg_s' => 'date_format:H:i',
                'ter_e' => 'date_format:H:i',
                'ter_s' => 'date_format:H:i',
                'qua_e' => 'date_format:H:i',
                'qua_s' => 'date_format:H:i',
                'qui_e' => 'date_format:H:i',
                'qui_s' => 'date_format:H:i',
                'sex_e' => 'date_format:H:i',
                'sex_s' => 'date_format:H:i',
                'sab_e' => 'date_format:H:i',
                'sab_s' => 'date_format:H:i',

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
                    $ctps = $internship->ctps;
                    $ctps->updated_at = Carbon::now();
                }

            } else { // New
                $internship->created_at = Carbon::now();

                $schedule->created_at = Carbon::now();

                if ($boolData->hasCTPS)
                    $ctps->created_at = Carbon::now();
            }

            if ($boolData->hasCTPS)
            {
                $ctps->ctps = $validatedData->ctps;
                $ctps->save();

                $internship->ctps_id = $ctps->id;
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
            $schedule->seg4_e = $validatedData->seg_e;
            $schedule->seg_s = $validatedData->seg_s;

            $internship->ra = $validatedData->ra;
            $internship->company_id = $validatedData->company;
            $internship->sector_id = $validatedData->sector;
            $internship->coordinator_id = Auth::user()->coordinator();;
            $internship->schedule_id = $validatedData->campo;
            $internship->state_id = $validatedData->campo;
            $internship->supervisor_id = $validatedData->campo;
            $internship->start = $validatedData->campo;
            $internship->end = $validatedData->campo;
            $internship->protocolo = $validatedData->campo;
            $internship->atividades = $validatedData->campo;
            $internship->observacao = $validatedData->campo;
            $internship->motivo_cancelamento = $validatedData->campo;
            $internship->ativo = $validatedData->campo;

            $saved = $internship->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.coordenador.index')->with($params);
    }
}
