<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Sector;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    public function index()
    {
        $supervisors = Supervisor::all();
        return view('coordinator.company.supervisor.index')->with(['supervisors' => $supervisors]);
    }

    public function getAjax()
    {
        $supervisors = Supervisor::all();
        return response()->json(
            ['supervisors' => $supervisors],
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getAjaxFromCompany($id)
    {
        $supervisors = Company::findOrFail($id)->supervisors;
        return response()->json(
            ['supervisors' => $supervisors],
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function new()
    {
        $companies = Company::all()->where('ativo', '=', true);
        return view('coordinator.company.supervisor.new')->with(['companies' => $companies]);
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('coordenador.empresa.supervisor.index');
        }

        $supervisor = Supervisor::findOrFail($id);
        $companies = Company::all()->where('ativo', '=', true);

        return view('coordinator.company.supervisor.edit')->with([
            'supervisor' => $supervisor, 'companies' => $companies,
        ]);
    }

    public function save(Request $request)
    {
        $supervisor = new Supervisor();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'supervisorName' => 'required|max:50',
                'supervisorEmail' => 'required|max:50',
                'supervisorFone' => 'required|max:12',
                'company' => 'required|min:1',
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $supervisor = Supervisor::all()->find($id);

                $supervisor->updated_at = Carbon::now();
            } else { // New
                $supervisor->created_at = Carbon::now();
            }

            $supervisor->nome = $validatedData->supervisorName;
            $supervisor->email = $validatedData->supervisorEmail;
            $supervisor->telefone = $validatedData->supervisorFone;
            $supervisor->company_id = $validatedData->company;

            $saved = $supervisor->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('coordenador.empresa.supervisor.index')->with($params);
    }

    public function saveAjax(Request $request)
    {
        // FAZ AQUI DEPOIS PAPITO
        $supervisor = new Supervisor();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = \Validator::make($request->all(), [
                'name' => 'required|max:50',
                'description' => 'required',
                'active' => 'required|boolean'
            ]);

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()]);
            }

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $supervisor = Sector::all()->find($id);

                $supervisor->updated_at = Carbon::now();
            } else { // New
                $supervisor->created_at = Carbon::now();
            }

            $supervisor->nome = $request->input('name');
            $supervisor->descricao = $request->input('description');
            $supervisor->ativo = $request->input('active');

            $saved = $supervisor->save();

            $params['saved'] = $saved;
        }

        return response()->json($params);
    }
}
