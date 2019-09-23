<?php

namespace App\Http\Controllers\Coordinator;

use App\Http\Requests\Coordinator\StoreCompany;
use App\Http\Requests\Coordinator\UpdateCompany;
use App\Models\Address;
use App\Models\Agreement;
use App\Models\Company;
use App\Models\Course;
use App\Models\Sector;
use App\Models\State;
use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;

class CompanyController extends Controller
{
    public function __construct()
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
        $sectors = Sector::all()->where('active', '=', true)->merge($company->sectors)->sortBy('id');
        $courses = Course::all()->where('active', '=', true)->merge($company->courses)->sortBy('id');

        return view('coordinator.company.edit')->with([
            'company' => $company, 'address' => $address, 'sectors' => $sectors, 'courses' => $courses,
        ]);
    }

    public function show($id)
    {
        $company = Company::findOrFail($id);
        $address = $company->address;

        return view('coordinator.company.details')->with(['company' => $company, 'address' => $address]);
    }

    public function pdf($id)
    {
        ini_set('max_execution_time', 300);

        $cIds = Auth::user()->coordinator_courses_id;
        $company = Company::findOrFail($id);

        $data = [
            'company' => $company,
            'internships' => $company->internships->where('state_id', '=', State::OPEN)->sortBy('student.nome'),
            'finished_internships' => $company->internships->where('state_id', '=', State::FINISHED)->sortBy('student.nome'),
            'courses' => Course::findOrFail($cIds),
        ];

        $pdf = PDF::loadView('pdf.company.students', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('estagiarios.pdf');
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

        $saved = $address->save();

        $company->address_id = $address->id;
        $saved = $company->save();

        $company->syncCourses(array_map('intval', $validatedData->courses));
        $company->syncSectors(array_map('intval', $validatedData->sectors));

        if ($validatedData->hasAgreement) {
            $agreement = new Agreement();

            $agreement->start_date = $validatedData->startDate;
            $agreement->end_date = SystemConfiguration::getAgreementExpiration($agreement->start_date);
            $agreement->active = true;
            $agreement->observation = $validatedData->observation;

            $agreement->company_id = $company->id;
            $saved = $agreement->save();

            if ($saved) {
                $agreement->createUser();
            }
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
        $company = Company::with(['address'])->findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de empresa";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

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
