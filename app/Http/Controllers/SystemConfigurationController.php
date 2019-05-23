<?php

namespace App\Http\Controllers;

use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SystemConfigurationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:systemConfiguration-list');
        $this->middleware('permission:systemConfiguration-create', ['only' => ['new', 'save']]);
        $this->middleware('permission:systemConfiguration-edit', ['only' => ['edit', 'save']]);
    }

    public function index()
    {
        $systemConfigs = SystemConfiguration::all();
        return view('admin.system.configurations.parameters.index')->with(['systemConfigs' => $systemConfigs]);
    }

    public function new()
    {
        return view('admin.system.configurations.parameters.new');
    }

    public function edit($id)
    {

        if (!is_numeric($id)) {
            return redirect()->route('admin.curso.index');
        }

        $systemConfig = SystemConfiguration::findOrFail($id);
        return view('admin.system.configurations.parameters.edit')->with(['systemConfig' => $systemConfig]);
    }

    public function save(Request $request)
    {
        $systemConfig = new SystemConfiguration();
        $params = [];
        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'name' => 'required|max:60',
                'cep' => 'required|numeric',
                'uf' => 'required|max:2',
                'cidade' => 'required|max:30',
                'rua' => 'required|max:50',
                'numero' => 'required|max:6',
                'bairro' => 'required|max:50',
                'fone' => 'required|max:11',
                'email' => 'required|max:50',
                'ramal' => 'max:5',
                'validade_convenio' => 'required|numeric|min:1'
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $systemConfig = SystemConfiguration::all()->find($id);

                $systemConfig->updated_at = Carbon::now();
            } else {
                $systemConfig->created_at = Carbon::now();
            }

            $systemConfig->nome = $validatedData->name;
            $systemConfig->cep = $validatedData->cep;
            $systemConfig->uf = $validatedData->uf;
            $systemConfig->cidade = $validatedData->cidade;
            $systemConfig->rua = $validatedData->rua;
            $systemConfig->numero = $validatedData->numero;
            $systemConfig->bairro = $validatedData->bairro;
            $systemConfig->fone = $validatedData->fone;
            $systemConfig->email = $validatedData->email;
            $systemConfig->ramal = $validatedData->ramal;
            $systemConfig->validade_convenio = $validatedData->validade_convenio;

            $saved = $systemConfig->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.configuracoes.parametros.index')->with($params);
    }
}
