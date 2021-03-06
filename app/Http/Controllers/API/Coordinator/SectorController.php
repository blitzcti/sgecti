<?php

namespace App\Http\Controllers\API\Coordinator;

use App\APIUtils;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Coordinator\StoreSector;
use App\Http\Requests\API\Coordinator\UpdateSector;
use App\Models\Company;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:companySector-list');
        $this->middleware('permission:companySector-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:companySector-edit', ['only' => ['edit', 'update']]);
    }

    public function get(Request $request)
    {
        $sectors = Sector::all()->sortBy('name');

        if (!is_array($sectors)) {
            $sectors = $sectors->toArray();
        }

        if (!empty($request->q)) {
            $sectors = APIUtils::search($sectors, $request->q, 'name');
        }

        return response()->json(
            array_values($sectors),
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getById($id)
    {
        $sector = Sector::findOrFail($id);

        return response()->json(
            $sector,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getFromCompany($id, Request $request)
    {
        $sectors = Company::findOrFail($id)->sectors->sortBy('name');

        if (!is_array($sectors)) {
            $sectors = $sectors->toArray();
        }

        if (!empty($request->q)) {
            $sectors = APIUtils::search($sectors, $request->q, 'name');
        }

        return response()->json(
            array_values($sectors),
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function store(StoreSector $request)
    {
        $sector = new Sector();
        $params = [];

        $validatedData = (object)$request->validated();

        $sector->name = $validatedData->name;
        $sector->description = $validatedData->description;
        $sector->active = $validatedData->active;

        $saved = $sector->save();

        $params['saved'] = $saved;
        $params['id'] = $sector->id;

        return response()->json($params);
    }

    public function update($id, UpdateSector $request)
    {
        $sector = Sector::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $sector->name = $validatedData->name;
        $sector->description = $validatedData->description;
        $sector->active = $validatedData->active;

        $saved = $sector->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }
}
