<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Agreement;
use App\Models\Company;
use App\Models\Course;
use App\Models\Sector;
use App\Rules\CNPJ;
use App\Rules\CPF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:company-list');
        $this->middleware('permission:company-create', ['only' => ['new', 'save']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'save']]);
    }

    public function index()
    {
        $companies = Company::all();
        return view('coordinator.company.index')->with(['companies' => $companies]);
    }

    public function new()
    {
        $sectors = Sector::all()->where('ativo', '=', true);
        $courses = Course::all()->where('active', '=', true);

        return view('coordinator.company.new')->with(['sectors' => $sectors, 'courses' => $courses]);
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('coordenador.empresa.index');
        }

        $company = Company::findOrFail($id);
        $address = $company->address;
        $sectors = Sector::all()->where('ativo', '=', true);
        $courses = Course::all()->where('active', '=', true);
        $agreement = $company->agreements->last();

        return view('coordinator.company.edit')->with([
            'company' => $company, 'address' => $address, 'sectors' => $sectors, 'courses' => $courses, 'agreement' => $agreement
        ]);
    }

    public function save(Request $request)
    {
        $company = new Company();
        $params = [];

        if (!$request->exists('cancel')) {
            $boolData = (object)$request->validate([
                'pj' => 'required|boolean',
                'hasConvenio' => 'required|boolean'
            ]);

            $validatedData = (object)$request->validate([
                'cpf_cnpj' => ['required', 'numeric', ($boolData->pj) ? new CNPJ : new CPF, (!$request->exists('id')) ? 'unique:companies,cpf_cnpj' : ''],
                'active' => 'required|boolean',
                'name' => 'required|max:100',
                'fantasyName' => 'max:100',
                'email' => 'required|max:100',
                'fone' => 'required|max:11',
                'representative' => 'required|max:50',
                'representativeRole' => 'required|max:50',

                'cep' => 'required|max:9',
                'uf' => 'required|max:2',
                'cidade' => 'required|max:30',
                'rua' => 'required|max:50',
                'complemento' => 'max:50',
                'numero' => 'required|max:6',
                'bairro' => 'required|max:50',

                'sectors' => 'required|array|min:1',

                'courses' => 'required|array|min:1',

                'expirationDate' => (($boolData->hasConvenio) ? 'required|date' : 'date'),
                'observation' => 'max:200',
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');

                $company = Company::all()->find($id);
                $company->updated_at = Carbon::now();

                $address = $company->address;
                $address->updated_at = Carbon::now();

                $agreement = $company->agreements->last();

                $log = "Alteração de empresa";
                $log .= "\nDados antigos: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                //$log .= "\nDados antigos (endereço): " . json_encode($address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                //$log .= "\nDados antigos (convênio): " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else { // New
                $address = new Address();
                $agreement = new Agreement();

                $company->created_at = Carbon::now();
                $company->cpf_cnpj = $validatedData->cpf_cnpj;
                $company->pj = $boolData->pj;

                $log = "Nova empresa";
            }

            $log .= "\nUsuário: " . Auth::user()->name;

            $company->nome = $validatedData->name;
            $company->nome_fantasia = $validatedData->fantasyName;
            $company->email = $validatedData->email;
            $company->telefone = $validatedData->fone;
            $company->representante = $validatedData->representative;
            $company->cargo = $validatedData->representativeRole;
            $company->ativo = $validatedData->active;

            $log .= "\nNovos dados: " . json_encode($company, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $address->cep = $validatedData->cep;
            $address->uf = $validatedData->uf;
            $address->cidade = $validatedData->cidade;
            $address->rua = $validatedData->rua;
            $address->complemento = $validatedData->complemento;
            $address->numero = $validatedData->numero;
            $address->bairro = $validatedData->bairro;

            $log .= "\nNovos dados (endereço): " . json_encode($address, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            $saved = $address->save();

            $company->address_id = $address->id;
            $saved = $company->save();

            $company->syncCourses(array_map('intval', $validatedData->courses));
            $company->syncSectors(array_map('intval', $validatedData->sectors));

            if($boolData->hasConvenio)
            {
                $agreement->validade = $validatedData->expirationDate;
                $agreement->observacao = $validatedData->observation;

                $log .= "\nNovos dados (convênio): " . json_encode($agreement, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

                $agreement->company_id = $company->id;
                $saved = $agreement->save();
            }

            if ($saved) {
                Log::info($log);
            } else {
                Log::error("Erro ao salvar empresa");
            }

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('coordenador.empresa.index')->with($params);
    }
}
