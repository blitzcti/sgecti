<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSector;
use App\Models\Company;
use App\Models\Sector;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectorController extends Controller
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
        $sectors = Sector::all();
        if (!empty($request->q)) {
            $sectors = $this->search($sectors->toArray(), $request->q, 'name');
        }

        return response()->json(
            $sectors,
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
            $sectors,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function store(Request $request)
    {
        $sector = new Sector();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = \Validator::make($request->all(), (new StoreSector())->rules());

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()]);
            }

            $sector->created_at = Carbon::now();
            $sector->name = $request->input('name');
            $sector->description = $request->input('description');
            $sector->active = $request->input('active');

            $saved = $sector->save();

            $params['saved'] = $saved;
        }

        return response()->json($params);
    }

    public function update($id, Request $request)
    {
        $sector = Sector::all()->find($id);
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = \Validator::make($request->all(), (new StoreSector())->rules());

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()]);
            }

            $sector->updated_at = Carbon::now();
            $sector->name = $request->input('name');
            $sector->description = $request->input('description');
            $sector->active = $request->input('active');

            $saved = $sector->save();

            $params['saved'] = $saved;
        }

        return response()->json($params);
    }
}
