<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coordinator;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:coordinator-list');
        $this->middleware('permission:coordinator-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:coordinator-edit', ['only' => ['edit', 'update']]);
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
        $coordinators = Coordinator::all()->sortBy('id');
        if (!empty($request->q)) {
            $coordinators = $this->search($coordinators->toArray(), $request->q, 'name');
        }

        return response()->json(
            array_values($coordinators->toArray()),
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getById($id)
    {
        $coordinators = Coordinator::findOrFail($id);

        return response()->json(
            $coordinators,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByCourse($id, Request $request)
    {
        $coordinators = Coordinator::with('user')->whereNull('temp_of')->where('course_id', '=', $id)->get();
        if (!empty($request->q)) {
            $coordinators = $this->search($coordinators->toArray(), $request->q, 'name');
        }

        return response()->json(
            array_values($coordinators->toArray()),
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }
}
