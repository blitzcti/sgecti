<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AgreementController extends Controller
{
    public function index()
    {
        $agreements = Agreement::all();
        return view('coordinator.company.agreement.index')->with(['agreements' => $agreements]);
    }

    public function new()
    {
        $companies = Company::all()->where('ativo', '=', true);
        return view('coordinator.company.agreement.new')->with(['companies' => $companies]);
    }

    public function edit($id)
    {
        $agreement = Agreement::findOrFail($id);
        return view('coordinator.company.agreement.edit')->with(['agreement' => $agreement]);
    }

    public function save(Request $request)
    {
        $agreement = new Agreement();
        $params = [];

        if (!$request->exists('cancel')) {

            $validatedData = (object)$request->validate([
                'company' => 'required|numeric:1',
                'expirationDate' => 'required|date',
                'observation' => 'max:200',
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');

                $agreement = Agreement::all()->find($id);
                $agreement->updated_at = Carbon::now();

                Log::info("Alteração");
                Log::info("Dados antigos: " . json_encode($agreement, JSON_UNESCAPED_UNICODE));
            } else { // New
                $agreement = new Agreement();
                $agreement->created_at = Carbon::now();
            }

            $agreement->company_id = $validatedData->company;
            $agreement->validade = $validatedData->expirationDate;
            $agreement->observacao = $validatedData->observation;

            $saved = $agreement->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('coordenador.empresa.convenio.index')->with($params);
    }
}
