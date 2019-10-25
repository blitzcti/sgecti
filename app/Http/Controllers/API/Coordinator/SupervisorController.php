<?php

namespace App\Http\Controllers\API\Coordinator;

use App\APIUtils;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Coordinator\StoreSupervisor;
use App\Http\Requests\API\Coordinator\UpdateSupervisor;
use App\Models\Company;
use App\Models\Supervisor;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:companySupervisor-list');
        $this->middleware('permission:companySupervisor-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:companySupervisor-edit', ['only' => ['edit', 'update']]);
    }

    public function get(Request $request)
    {
        $supervisors = Supervisor::all()->sortBy('id');
        if (!empty($request->q)) {
            $supervisors = APIUtils::search($supervisors->toArray(), $request->q, 'name');
        }

        return response()->json(
            $supervisors,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getById($id)
    {
        $supervisor = Supervisor::findOrFail($id);

        return response()->json(
            $supervisor,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getFromCompany($id, Request $request)
    {
        $supervisors = Company::findOrFail($id)->supervisors;
        if (!empty($request->q)) {
            $supervisors = APIUtils::search($supervisors->toArray(), $request->q, 'name');
        }

        return response()->json(
            $supervisors,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function store(StoreSupervisor $request)
    {
        $supervisor = new Supervisor();
        $params = [];

        $validatedData = (object)$request->validated();

        $supervisor->company_id = $validatedData->company;
        $supervisor->name = $validatedData->name;
        $supervisor->email = $validatedData->email;
        $supervisor->phone = $validatedData->phone;

        $saved = $supervisor->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }

    public function update($id, UpdateSupervisor $request)
    {
        $supervisor = Supervisor::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $supervisor->company_id = $validatedData->company;
        $supervisor->name = $validatedData->name;
        $supervisor->email = $validatedData->email;
        $supervisor->phone = $validatedData->phone;

        $saved = $supervisor->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }
}
