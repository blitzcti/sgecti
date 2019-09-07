<?php

namespace App\Http\Controllers\API\Coordinator;

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

    /**
     * Search for a string in a specific array column
     *
     * @param array $array
     * @param string $q
     * @param null|string $col
     *
     * @return array
     */
    function search($array, $q, $col = null)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            if ($col == null) {
                return (strpos(strtoupper($v), strtoupper($q)) !== false);
            } else {
                return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
            }
        }, ARRAY_FILTER_USE_BOTH);
        return array_values($array);
    }

    public function get(Request $request)
    {
        $sectors = Sector::all()->sortBy('id');
        if (!empty($request->q)) {
            $sectors = $this->search($sectors->toArray(), $request->q, 'name');
        }

        return response()->json(
            array_values($sectors->toArray()),
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
        $sectors = Company::findOrFail($id)->sectors;
        if (!empty($request->q)) {
            $sectors = $this->search($sectors->toArray(), $request->q, 'name');
        }

        return response()->json(
            array_values($sectors->toArray()),
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

        $sector->name = $request->input('name');
        $sector->description = $request->input('description');
        $sector->active = $request->input('active');

        $saved = $sector->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }

    public function update($id, UpdateSector $request)
    {
        $sector = Sector::findOrFail($id);
        $params = [];

        $sector->name = $request->input('name');
        $sector->description = $request->input('description');
        $sector->active = $request->input('active');

        $saved = $sector->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }
}
