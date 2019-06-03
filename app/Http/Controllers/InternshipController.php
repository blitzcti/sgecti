<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Internship;
use App\Models\State;
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
        return view('coordinator.internship.new')->with(['companies' => $companies, 'states' => $states]);
    }

    public function edit()
    {

    }

    public function save(Request $request)
    {
        $internship = new Internship();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'ra' => 'required|numeric|min:1',
                'active' => 'required|numeric|min:1',
                'company' => 'required|min:1',
                'sector' => 'required|min:1',

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

                'start' => 'date|required',
                'end' => 'date|required',
                'state' => 'required|min:1',
                'protocol' => 'required|min:5',
                'activities' => 'required|max:4000',
                'observation' => 'max:200',
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $internship = Internship::all()->find($id);

                $internship->updated_at = Carbon::now();
            } else { // New
                $internship->created_at = Carbon::now();
            }

            $internship->user_id = $validatedData->user;
            $internship->course_id = $validatedData->course;
            $internship->vigencia_ini = $validatedData->start;
            $internship->vigencia_fim = $validatedData->end;
            $internship->user_id = $validatedData->user;
            $internship->course_id = $validatedData->course;
            $internship->vigencia_ini = $validatedData->start;
            $internship->vigencia_fim = $validatedData->end;
            $internship->vigencia_fim = $validatedData->end;
            $internship->vigencia_fim = $validatedData->end;

            $saved = $internship->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.coordenador.index')->with($params);
    }
}
