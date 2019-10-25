<?php

namespace App\Http\Controllers\API\Coordinator;

use App\APIUtils;
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

    public function get(Request $request)
    {
        $internships = Internship::all()->sortBy('id');
        if (!empty($request->q)) {
            $internships = APIUtils::search($internships->toArray(), $request->q, 'state_id');
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
