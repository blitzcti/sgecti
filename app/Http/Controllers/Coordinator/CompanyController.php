<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Requests\Coordinator\DestroyCompany;
use App\Http\Requests\Coordinator\StoreCompany;
use App\Http\Requests\Coordinator\UpdateCompany;
use App\Models\Address;
use App\Models\Agreement;
use App\Models\Company;
use App\Models\Course;
use App\Models\Sector;
use App\Models\State;
use App\Models\SystemConfiguration;
use Illuminate\Routing\Controller;
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
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $companies = Company::all();
        return view('coordinator.company.index')->with(['companies' => $companies]);
    }

    public function create()
    {
        $sectors = Sector::actives()->orderBy('id')->get();
        $courses = Course::actives()->orderBy('id')->get();

        return view('coordinator.company.new')->with(['sectors' => $sectors, 'courses' => $courses]);
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $address = $company->address;
        $sectors = Sector::getActives()->merge($company->sectors)->sortBy('id');
        $courses = Course::getActives()->merge($company->courses)->sortBy('id');

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

        $company = Company::findOrFail($id);

        $data = [
            'company' => $company,
            'internships' => $company->internships->where('state_id', '=', State::OPEN)->sortBy('student.nome'),
            'finished_internships' => $company->internships->where('state_id', '=', State::FINISHED)->sortBy('student.nome'),
            'courses' => Auth::user()->coordinator_of,
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

        $user = Auth::user();
        $log = "Nova empresa";
        $log .= "\nUsuário: {$user->name}";

        $company->cpf_cnpj = $validatedData->cpfCnpj;
        $company->ie = $validatedData->ie;
        $company->pj = $validatedData->pj;
        $company->name = $validatedData->companyName;
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
        $cUser = $company->user;
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Alteração de empresa";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $company->ie = $validatedData->ie;
        $company->name = $validatedData->companyName;
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

            if ($cUser != null) {
                $cUser->name = $company->representative_name;
                $cUser->email = $company->email;
                $cUser->save();
            }
        } else {
            Log::error("Erro ao salvar empresa");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.index')->with($params);
    }

    public function destroy($id, DestroyCompany $request)
    {
        $company = Company::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Exclusão de empresa";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $company->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir empresa");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';
        return redirect()->route('coordenador.empresa.index')->with($params);
    }
}
