<?php

namespace App\Http\Controllers\Coordinator;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coordinator\DestroySupervisor;
use App\Http\Requests\Coordinator\StoreSupervisor;
use App\Http\Requests\Coordinator\UpdateSupervisor;
use App\Models\Company;
use App\Models\Supervisor;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    public function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:companySupervisor-list');
        $this->middleware('permission:companySupervisor-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:companySupervisor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:companySupervisor-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $supervisors = Supervisor::all();
        return view('coordinator.company.supervisor.index')->with(['supervisors' => $supervisors]);
    }

    public function indexByCompany($id)
    {
        $company = Company::findOrFail($id);
        $supervisors = $company->supervisors;
        return view('coordinator.company.supervisor.index')->with(['company' => $company, 'supervisors' => $supervisors]);
    }

    public function create()
    {
        $companies = Company::actives()->orderBy('id')->get();
        $c = request()->c;
        return view('coordinator.company.supervisor.new')->with(['companies' => $companies, 'c' => $c]);
    }

    public function edit($id)
    {
        $supervisor = Supervisor::findOrFail($id);
        $companies = Company::getActives()->merge([$supervisor->company])->sortBy('id');

        return view('coordinator.company.supervisor.edit')->with([
            'supervisor' => $supervisor, 'companies' => $companies,
        ]);
    }

    public function store(StoreSupervisor $request)
    {
        $supervisor = new Supervisor();
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Novo supervisor";
        $log .= "\nUsuário: {$user->name}";

        $supervisor->name = $validatedData->supervisorName;
        $supervisor->email = $validatedData->supervisorEmail;
        $supervisor->phone = $validatedData->supervisorPhone;
        $supervisor->company_id = $validatedData->company;

        $saved = $supervisor->save();
        $log .= "\nNovos dados: " . json_encode($supervisor, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar supervisor");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.supervisor.index')->with($params);
    }

    public function update($id, UpdateSupervisor $request)
    {
        $supervisor = Supervisor::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Alteração de supervisor";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($supervisor, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $supervisor->name = $validatedData->supervisorName;
        $supervisor->email = $validatedData->supervisorEmail;
        $supervisor->phone = $validatedData->supervisorPhone;
        $supervisor->company_id = $validatedData->company;

        $saved = $supervisor->save();
        $log .= "\nNovos dados: " . json_encode($supervisor, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar supervisor");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.supervisor.index')->with($params);
    }

    public function destroy($id, DestroySupervisor $request)
    {
        $supervisor = Supervisor::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Exclusão de supervisor";
        $log .= "\nUsuário: {$user->name}";
        $log .= "\nDados antigos: " . json_encode($supervisor, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $supervisor->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir supervisor");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';

        return redirect()->route('coordenador.empresa.supervisor.index')->with($params);
    }
}
