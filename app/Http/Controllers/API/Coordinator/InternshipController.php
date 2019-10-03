<?php

namespace App\Http\Controllers\API\Coordinator;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:internship-list');
        $this->middleware('permission:internship-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:internship-edit', ['only' => ['edit', 'update']]);
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
        $internships = Internship::all()->sortBy('id');
        if (!empty($request->q)) {
            $internships = $this->search($internships->toArray(), $request->q, 'state_id');
        }

        return response()->json(
            $internships,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getById($id)
    {
        $internship = Internship::with(['company', 'sector', 'supervisor'])->findOrFail($id);

        return response()->json(
            $internship,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByRA($ra)
    {
        $internships = Internship::where('ra', '=', $ra)->get()->sortBy('id');

        return response()->json(
            $internships,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }
}
