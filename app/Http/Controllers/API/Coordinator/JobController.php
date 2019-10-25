<?php

namespace App\Http\Controllers\API\Coordinator;

use App\APIUtils;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:job-list');
        $this->middleware('permission:job-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:job-edit', ['only' => ['edit', 'update']]);
    }

    public function get(Request $request)
    {
        $jobs = Job::all()->sortBy('id');
        if (!empty($request->q)) {
            $jobs = APIUtils::search($jobs->toArray(), $request->q, 'state_id');
        }

        return response()->json(
            $jobs,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getById($id)
    {
        $job = Job::findOrFail($id);

        return response()->json(
            $job,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }

    public function getByRA($ra)
    {
        $jobs = Job::where('ra', '=', $ra)->get()->sortBy('id');

        return response()->json(
            $jobs,
            200,
            [
                'Content-Type' => 'application/json; charset=UTF-8',
                'charset' => 'utf-8'
            ],
            JSON_UNESCAPED_UNICODE);
    }
}
