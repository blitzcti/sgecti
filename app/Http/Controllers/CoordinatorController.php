<?php

namespace App\Http\Controllers;

use App\Coordinator;
use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    public function index()
    {
        $coordinators = Coordinator::all();

        return view('admin.coordinator.index')->with(['coordinators' => $coordinators]);
    }

    public function new()
    {

    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {

    }
}