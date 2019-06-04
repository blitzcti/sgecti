<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Internship;
use App\Models\State;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $params = [];

        if (!$request->exists('cancel')) {
            $boolData = (object)$request->validate([
                'hasCNPJ' => 'required|boolean'
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

                'ctps' => (($boolData->hasCNPJ) ? 'required|numeric|min:11' : ''),
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $internship = Internship::all()->find($id);

                $internship->updated_at = Carbon::now();
            } else { // New
                $internship->created_at = Carbon::now();
            }

            $internship->ra = $validatedData->campo;
            //ctps
            $internship->company_id = $validatedData->campo;
            $internship->sector_id = $validatedData->campo;
            $internship->coordinator_id = $validatedData->campo;
            $internship->schedule_id = $validatedData->campo;
            $internship->state_id = $validatedData->campo;
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
