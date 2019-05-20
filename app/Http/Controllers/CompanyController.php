<?php

namespace App\Http\Controllers;

use App\Company;
use App\Course;
use App\Rules\CNPJ;
use App\Rules\CPF;
use App\Sector;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:company-list');
        $this->middleware('permission:company-create', ['only' => ['new', 'save']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'save']]);
    }

    public function index()
    {
        $companies = Company::all();
        return view('coordinator.company.index')->with(['companies' => $companies]);
    }

    public function new()
    {
        $sectors = Sector::all()->where('ativo', '=', true);
        $courses = Course::all()->where('active', '=', true);

        return view('coordinator.company.new')->with(['sectors' => $sectors, 'courses' => $courses]);
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
            $validatedData = (object)$request->validate([
                'pj' => 'required|boolean'
            ]);

            if ($validatedData->pj) {
                $validatedData = (object)$request->validate([
                    'cpf_cnpj' =>  new CNPJ,
                ]);
            } else {
                $validatedData = (object)$request->validate([
                    'cpf_cnpj' =>  new CPF,
                ]);
            }
        }

        return redirect()->route('coordenador.empresa.index')->with($params);
    }
}
