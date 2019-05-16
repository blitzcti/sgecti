<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('coordinator.company.index')->with(['companies' => $companies]);
    }

    public function new()
    {
        return view('coordinator.company.new');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('coordenador.empresa.index');
        }

        $company = Company::findOrFail($id);

        return view('coordinator.company.edit')->with(['company' => $company]);
    }

    public function save(Request $request)
    {
        $company = new Company();
        $params = [];

        if (!$request->exists('cancel')) {

        }

        return redirect()->route('admin.curso.index')->with($params);
    }
}
