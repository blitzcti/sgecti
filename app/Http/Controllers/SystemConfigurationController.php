<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSystemConfiguration;
use App\Http\Requests\UpdateSystemConfiguration;
use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SystemConfigurationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:systemConfiguration-list');
        $this->middleware('permission:systemConfiguration-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:systemConfiguration-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $systemConfigs = SystemConfiguration::all();
        return view('admin.system.configurations.parameters.index')->with(['systemConfigs' => $systemConfigs]);
    }

    public function create()
    {
        return view('admin.system.configurations.parameters.new');
    }

    public function edit($id)
    {

        if (!ctype_digit($id)) {
            return redirect()->route('admin.curso.index');
        }

        $systemConfig = SystemConfiguration::findOrFail($id);
        return view('admin.system.configurations.parameters.edit')->with(['systemConfig' => $systemConfig]);
    }

    public function store(StoreSystemConfiguration $request)
    {
        $systemConfig = new SystemConfiguration();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Nova configuração do sistema";
        $log .= "\nUsuário: " . Auth::user()->name;

        $systemConfig->created_at = Carbon::now();
        $systemConfig->name = $validatedData->name;
        $systemConfig->cep = $validatedData->cep;
        $systemConfig->uf = $validatedData->uf;
        $systemConfig->city = $validatedData->city;
        $systemConfig->street = $validatedData->street;
        $systemConfig->number = $validatedData->number;
        $systemConfig->district = $validatedData->district;
        $systemConfig->phone = $validatedData->phone;
        $systemConfig->email = $validatedData->email;
        $systemConfig->extension = $validatedData->extension;
        $systemConfig->agreement_expiration = $validatedData->agreementExpiration;

        $saved = $systemConfig->save();
        $log .= "\nNovos dados: " . json_encode($systemConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração do sistema");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.configuracoes.parametros.index')->with($params);
    }

    public function update($id, UpdateSystemConfiguration $request)
    {
        $systemConfig = SystemConfiguration::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de configuração do sistema";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($systemConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $systemConfig->updated_at = Carbon::now();
        $systemConfig->name = $validatedData->name;
        $systemConfig->cep = $validatedData->cep;
        $systemConfig->uf = $validatedData->uf;
        $systemConfig->city = $validatedData->city;
        $systemConfig->street = $validatedData->street;
        $systemConfig->number = $validatedData->number;
        $systemConfig->district = $validatedData->district;
        $systemConfig->phone = $validatedData->phone;
        $systemConfig->email = $validatedData->email;
        $systemConfig->extension = $validatedData->extension;
        $systemConfig->agreement_expiration = $validatedData->agreementExpiration;

        $saved = $systemConfig->save();
        $log .= "\nNovos dados: " . json_encode($systemConfig, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração do sistema");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.configuracoes.parametros.index')->with($params);
    }
}
