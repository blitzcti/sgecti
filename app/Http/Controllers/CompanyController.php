<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Agreement;
use App\Models\Company;
use App\Models\CompanyCourses;
use App\Models\CompanySector;
use App\Models\Course;
use App\Models\Sector;
use App\Rules\CNPJ;
use App\Rules\CPF;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        return view('coordinator.company.edit')->with(['company' => $company]);
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
                'cpf_cnpj' => ['required', 'numeric', ($boolData->pj) ? new CNPJ : new CPF, 'unique:companies,cpf_cnpj'],
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

                'expirationDate' => (($boolData->hasConvenio) ? 'required|date' : ''),
                'observation' => (($boolData->hasConvenio) ? 'max:200' : ''),
            ]);

            if ($request->exists('id')) { // Edit
                //$id = $request->input('id');
                //$course = Course::all()->find($id);

                //$course->updated_at = Carbon::now();
                //Log::info("Alteração");
                //Log::info("Dados antigos: " . json_encode($course, JSON_UNESCAPED_UNICODE));
            } else { // New
                $address = new Address();
                $address->cep = $validatedData->cep;
                $address->uf = $validatedData->uf;
                $address->cidade = $validatedData->cidade;
                $address->rua = $validatedData->rua;
                $address->complemento = $validatedData->complemento;
                $address->numero = $validatedData->numero;
                $address->bairro = $validatedData->bairro;

                $company->created_at = Carbon::now();
                $company->cpf_cnpj = $validatedData->cpf_cnpj;
                $company->pj = $boolData->pj;
                $company->nome = $validatedData->name;
                $company->nome_fantasia = $validatedData->fantasyName;
                $company->email = $validatedData->email;
                $company->telefone = $validatedData->fone;
                $company->representante = $validatedData->representative;
                $company->cargo = $validatedData->representativeRole;
                $company->ativo = $validatedData->active;
            }

            $saved = $address->save();

            $company->address_id = $address->id;
            $saved = $company->save();

            $company->syncCourses($validatedData->courses);
            $company->syncSectors($validatedData->sectors);

            if($boolData->hasConvenio)
            {
                $agreement = new Agreement();
                $agreement->validade = $validatedData->validade;
                $agreement->obervacao = $validatedData->obervacao;

                $agreement->company_id = $company->id;
                $saved = $company->save();
            }

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('coordenador.empresa.index')->with($params);
    }
}
