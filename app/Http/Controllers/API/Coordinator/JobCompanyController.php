<?php

namespace App\Http\Controllers\API\Coordinator;

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

    /**
     * Search for a string in a specific array column
     *
     * @param array $array
     * @param string $q
     * @param null|string|array $col
     *
     * @return array
     */
    function search($array, $q, $col = null)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            if ($col == null) {
                return (strpos(strtoupper($v), strtoupper($q)) !== false);
            } else {
                if (is_array($col)) {
                    foreach ($col as $c) {
                        if (strpos(strtoupper($v[$c]), strtoupper($q)) !== false) {
                            return true;
                        }
                    }

                    return false;
                } else {
                    return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
                }
            }
        }, ARRAY_FILTER_USE_BOTH);

        return array_values($array);
    }

    public function get(Request $request)
    {
        $companies = JobCompany::all()->sortBy('id');
        if (!empty($request->q)) {
            $companies = $this->search($companies->toArray(), $request->q, ['name', 'fantasy_name', 'cpf_cnpj']);
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
        $company->name = $validatedData->name;
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
        $company->name = $validatedData->name;
        $company->fantasy_name = $validatedData->fantasyName;
        $company->representative_name = $validatedData->representativeName;
        $company->representative_role = $validatedData->representativeRole;
        $company->active = $validatedData->active;

        $saved = $company->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }
}
