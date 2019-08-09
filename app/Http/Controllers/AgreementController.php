<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgreement;
use App\Http\Requests\UpdateAgreement;
use App\Models\Agreement;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AgreementController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:companyAgreement-list');
        $this->middleware('permission:companyAgreement-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:companyAgreement-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $agreements = Agreement::all();
        return view('coordinator.company.agreement.index')->with(['agreements' => $agreements]);
    }

    public function create()
    {
        $companies = Company::all()->where('active', '=', true)->sortBy('id');
        return view('coordinator.company.agreement.new')->with(['companies' => $companies]);
    }

    public function edit($id)
    {
        $agreement = Agreement::findOrFail($id);
        return view('coordinator.company.agreement.edit')->with(['agreement' => $agreement]);
    }

    public function store(StoreAgreement $request)
    {
        $agreement = new Agreement();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo convênio";
        $log .= "\nUsuário: " . Auth::user()->name;

        $agreement->created_at = Carbon::now();
        $agreement->company_id = $validatedData->company;
        $agreement->expiration_date = $validatedData->expirationDate;
        $agreement->observation = $validatedData->observation;

        $saved = $agreement->save();
        $log .= "\nNovos dados: " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar convênio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.convenio.index')->with($params);
    }

    public function update($id, UpdateAgreement $request)
    {
        $agreement = Agreement::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de convênio";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $agreement->updated_at = Carbon::now();
        $agreement->expiration_date = $validatedData->expirationDate;
        $agreement->observation = $validatedData->observation;

        $saved = $agreement->save();
        $log .= "\nNovos dados: " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar convênio");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.convenio.index')->with($params);
    }
}
