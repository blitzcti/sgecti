<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;
use App\Models\Address;
use App\Models\Agreement;
use App\Models\Company;
use App\Models\Course;
use App\Models\Sector;
use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:company-list');
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $companies = Company::all();
        return view('coordinator.company.index')->with(['companies' => $companies]);
    }

    public function create()
    {
        $sectors = Sector::all()->where('active', '=', true)->sortBy('id');
        $courses = Course::all()->where('active', '=', true)->sortBy('id');

        return view('coordinator.company.new')->with(['sectors' => $sectors, 'courses' => $courses]);
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $address = $company->address;
        $sectors = Sector::all()->where('active', '=', true)->sortBy('id');
        $courses = Course::all()->where('active', '=', true)->sortBy('id');

        return view('coordinator.company.edit')->with([
            'company' => $company, 'address' => $address, 'sectors' => $sectors, 'courses' => $courses,
        ]);
    }

    public function details($id)
    {
        $company = Company::findOrFail($id);
        $address = $company->address;

        return view('coordinator.company.details')->with(['company' => $company, 'address' => $address]);
    }

    public function store(StoreCompany $request)
    {
        $company = new Company();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova empresa";
        $log .= "\nUsuário: " . Auth::user()->name;

        $company->cpf_cnpj = $validatedData->cpfCnpj;
        $company->ie = $validatedData->ie;
        $company->pj = $validatedData->pj;
        $company->name = $validatedData->name;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->email = $validatedData->email;
        $company->phone = $validatedData->phone;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;

        $address = new Address();

        $address->cep = $validatedData->cep;
        $address->uf = $validatedData->uf;
        $address->city = $validatedData->city;
        $address->street = $validatedData->street;
        $address->complement = $validatedData->complement;
        $address->number = $validatedData->number;
        $address->district = $validatedData->district;

        //$log .= "\nNovos dados (endereço): " . json_encode($address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $address->save();

        $company->address_id = $address->id;
        $saved = $company->save();

        $company->syncCourses(array_map('intval', $validatedData->courses));
        $company->syncSectors(array_map('intval', $validatedData->sectors));

        if ($validatedData->hasConvenio) {
            $agreement = new Agreement();

            $agreement->expiration_date = SystemConfiguration::getAgreementExpiration();
            $agreement->observation = $validatedData->observation;

            //$log .= "\nNovos dados (convênio): " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $agreement->company_id = $company->id;
            $saved = $agreement->save();
        }

        $log .= "\nNovos dados: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar empresa");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.index')->with($params);
    }

    public function update($id, UpdateCompany $request)
    {
        $company = Company::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de empresa";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //$log .= "\nDados antigos (endereço): " . json_encode($address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        //$log .= "\nDados antigos (convênio): " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $company->ie = $validatedData->ie;
        $company->name = $validatedData->name;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->email = $validatedData->email;
        $company->phone = $validatedData->phone;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;

        $address = $company->address;

        $address->cep = $validatedData->cep;
        $address->uf = $validatedData->uf;
        $address->city = $validatedData->city;
        $address->street = $validatedData->street;
        $address->complement = $validatedData->complement;
        $address->number = $validatedData->number;
        $address->district = $validatedData->district;

        //$log .= "\nNovos dados (endereço): " . json_encode($address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $address->save();

        $company->address_id = $address->id;
        $saved = $company->save();

        $company->syncCourses(array_map('intval', $validatedData->courses));
        $company->syncSectors(array_map('intval', $validatedData->sectors));

        $log .= "\nNovos dados: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar empresa");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.index')->with($params);
    }
}
