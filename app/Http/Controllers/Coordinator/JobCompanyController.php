<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\StoreJobCompany;
use App\Http\Requests\Coordinator\UpdateJobCompany;
use App\Models\JobCompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:jobCompany-list');
        $this->middleware('permission:jobCompany-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:jobCompany-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $companies = JobCompany::all();
        return view('coordinator.job.company.index')->with(['companies' => $companies]);
    }

    public function create()
    {
        return view('coordinator.job.company.new');
    }

    public function edit($id)
    {
        $company = JobCompany::findOrFail($id);

        return view('coordinator.job.company.edit')->with(['company' => $company,]);
    }

    public function show($id)
    {
        $company = JobCompany::findOrFail($id);

        return view('coordinator.job.company.details')->with(['company' => $company]);
    }

    public function store(StoreJobCompany $request)
    {
        $company = new JobCompany();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova empresa (CTPS)";
        $log .= "\nUsuário: " . Auth::user()->name;

        $company->cpf_cnpj = $validatedData->cpfCnpj;
        $company->ie = $validatedData->ie;
        $company->pj = $validatedData->pj;
        $company->name = $validatedData->name;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;

        $saved = $company->save();

        $log .= "\nNovos dados: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar empresa (CTPS)");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.trabalho.empresa.index')->with($params);
    }

    public function update($id, UpdateJobCompany $request)
    {
        $company = JobCompany::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de empresa (CTPS)";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $company->ie = $validatedData->ie;
        $company->name = $validatedData->name;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;
        $saved = $company->save();

        $log .= "\nNovos dados: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar empresa (CTPS)");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.trabalho.empresa.index')->with($params);
    }
}
