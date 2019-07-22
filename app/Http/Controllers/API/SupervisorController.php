<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupervisor;
use App\Models\Company;
use App\Models\Sector;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    /**
     * Search for a string in a specific array column
     *
     * @param array $array
     * @param string $q
     * @param string $col
     *
     * @return array
     */
    function search($array, $q, $col)
    {
        $array = array_filter($array, function ($v, $k) use ($q, $col) {
            return (strpos(strtoupper($v[$col]), strtoupper($q)) !== false);
        }, ARRAY_FILTER_USE_BOTH);
        $array = array_values($array);
        return $array;
    }

    public function get(Request $request)
    {
        $supervisors = Supervisor::all();
        if (!empty($request->q)) {
            $supervisors = $this->search($supervisors->toArray(), $request->q, 'name');
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

    public function getFromCompany($id, Request $request)
    {
        $supervisors = Company::findOrFail($id)->supervisors;
        if (!empty($request->q)) {
            $supervisors = $this->search($supervisors->toArray(), $request->q, 'name');
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

    public function store(Request $request)
    {
        $supervisor = new Supervisor();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = \Validator::make($request->all(), (new StoreSupervisor())->rules());

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()]);
            }

            $supervisor->created_at = Carbon::now();
            $supervisor->name = $request->input('supervisorName');
            $supervisor->email = $request->input('supervisorEmail');
            $supervisor->phone = $request->input('supervisorPhone');
            $supervisor->company_id = $request->input('company');

            $saved = $supervisor->save();

            $params['saved'] = $saved;
        }

        return response()->json($params);
    }

    public function update($id, Request $request)
    {
        $supervisor = Sector::all()->find($id);
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = \Validator::make($request->all(), (new StoreSupervisor())->rules());

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()]);
            }

            $supervisor->updated_at = Carbon::now();
            $supervisor->name = $request->input('supervisorName');
            $supervisor->email = $request->input('supervisorEmail');
            $supervisor->phone = $request->input('supervisorPhone');
            $supervisor->company_id = $request->input('company');

            $saved = $supervisor->save();

            $params['saved'] = $saved;
        }

        return response()->json($params);
    }
}
