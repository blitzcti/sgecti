<?php

namespace App\Http\Controllers\Admin;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DestroySystemConfiguration;
use App\Http\Requests\Admin\StoreSystemConfiguration;
use App\Http\Requests\Admin\UpdateSystemConfiguration;
use App\Models\SystemConfiguration;
use Illuminate\Support\Facades\Log;

class SystemConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:systemConfiguration-list');
        $this->middleware('permission:systemConfiguration-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:systemConfiguration-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:systemConfiguration-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $configs = SystemConfiguration::all();
        return view('admin.system.configurations.parameters.index')->with(['configs' => $configs]);
    }

    public function create()
    {
        return view('admin.system.configurations.parameters.new');
    }

    public function edit($id)
    {
        $config = SystemConfiguration::findOrFail($id);

        return view('admin.system.configurations.parameters.edit')->with(['config' => $config]);
    }

    public function store(StoreSystemConfiguration $request)
    {
        $config = new SystemConfiguration();
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Nova configuração do sistema";
        $log .= "\nUsuário: {$user->name}";

        $config->name = $validatedData->name;
        $config->cep = $validatedData->cep;
        $config->uf = $validatedData->uf;
        $config->city = $validatedData->city;
        $config->street = $validatedData->street;
        $config->number = $validatedData->number;
        $config->district = $validatedData->district;
        $config->phone = $validatedData->phone;
        $config->email = $validatedData->email;
        $config->extension = $validatedData->extension;
        $config->agreement_expiration = $validatedData->agreementExpiration;

        $saved = $config->save();
        $log .= "\nNovos dados: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração do sistema");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.configuracao.parametros.index')->with($params);
    }

    public function update($id, UpdateSystemConfiguration $request)
    {
        $config = SystemConfiguration::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Alteração de configuração do sistema";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $config->name = $validatedData->name;
        $config->cep = $validatedData->cep;
        $config->uf = $validatedData->uf;
        $config->city = $validatedData->city;
        $config->street = $validatedData->street;
        $config->number = $validatedData->number;
        $config->district = $validatedData->district;
        $config->phone = $validatedData->phone;
        $config->email = $validatedData->email;
        $config->extension = $validatedData->extension;
        $config->agreement_expiration = $validatedData->agreementExpiration;

        $saved = $config->save();
        $log .= "\nNovos dados: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração do sistema");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.configuracao.parametros.index')->with($params);
    }

    public function destroy($id, DestroySystemConfiguration $request)
    {
        $config = SystemConfiguration::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Exclusão de configuração do sistema";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $config->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir configuração do sistema");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';
        return redirect()->route('admin.configuracao.parametros.index')->with($params);
    }
}
