<?php

namespace App\Http\Controllers\API\Coordinator;

use App\APIUtils;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Coordinator\StoreJobCompany;
use App\Http\Requests\API\Coordinator\UpdateJobCompany;
use App\Models\JobCompany;
use Illuminate\Http\Request;

class JobCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:jobCompany-list');
        $this->middleware('permission:jobCompany-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:jobCompany-edit', ['only' => ['edit', 'update']]);
    }

    public function get(Request $request)
    {
        $companies = JobCompany::all()->sortBy('id');
        if (!empty($request->q)) {
            $companies = APIUtils::search($companies->toArray(), $request->q, ['name', 'fantasy_name', 'cpf_cnpj']);
        }

        return response()->json(
            $companies,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getById($id)
    {
        $company = JobCompany::findOrFail($id);

        return response()->json(
            $company,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function store(StoreJobCompany $request)
    {
        $company = new JobCompany();
        $params = [];

        $validatedData = (object)$request->validated();

        $company->cpf_cnpj = $validatedData->cpfCnpj;
        $company->ie = $validatedData->ie;
        $company->pj = $validatedData->pj;
        $company->name = $validatedData->companyName;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;

        $saved = $company->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }

    public function update($id, UpdateJobCompany $request)
    {
        $company = JobCompany::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $company->ie = $validatedData->ie;
        $company->name = $validatedData->companyName;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;

        $saved = $company->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }
}
