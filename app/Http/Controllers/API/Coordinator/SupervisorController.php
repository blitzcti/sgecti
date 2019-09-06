<?php

namespace App\Http\Controllers\API\Coordinator;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Coordinator\StoreSupervisor;
use App\Http\Requests\API\Coordinator\UpdateSupervisor;
use App\Models\Company;
use App\Models\Sector;
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
        $array = array_values($array);
        return $array;
    }

    public function get(Request $request)
    {
        $supervisors = Supervisor::all()->sortBy('id');
        if (!empty($request->q)) {
            $supervisors = $this->search($supervisors->toArray(), $request->q, 'name');
        }

        return response()->json(
            array_values($supervisors->toArray()),
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
            $supervisors = $this->search($supervisors->toArray(), $request->q, 'name');
        }

        return response()->json(
            array_values($supervisors->toArray()),
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

        $supervisor->name = $request->input('supervisorName');
        $supervisor->email = $request->input('supervisorEmail');
        $supervisor->phone = $request->input('supervisorPhone');
        $supervisor->company_id = $request->input('company');

        $saved = $supervisor->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }

    public function update($id, UpdateSupervisor $request)
    {
        $supervisor = Sector::findOrFail($id);
        $params = [];

        $supervisor->name = $request->input('supervisorName');
        $supervisor->email = $request->input('supervisorEmail');
        $supervisor->phone = $request->input('supervisorPhone');
        $supervisor->company_id = $request->input('company');

        $saved = $supervisor->save();

        $params['saved'] = $saved;

        return response()->json($params);
    }
}
