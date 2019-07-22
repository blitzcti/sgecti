<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSector;
use App\Http\Requests\UpdateSector;
use App\Models\Sector;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SectorController extends Controller
{
    function __construct()
    {
        $this->middleware('coordinator');
        $this->middleware('permission:companySector-list');
        $this->middleware('permission:companySector-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:companySector-edit', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        $sectors = Sector::all();
        return view('coordinator.company.sector.index')->with(['sectors' => $sectors]);
    }

    public function create()
    {
        return view('coordinator.company.sector.new');
    }

    public function edit($id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('coordenador.empresa.setor.index');
        }

        $sector = Sector::findOrFail($id);

        return view('coordinator.company.sector.edit')->with(['sector' => $sector]);
    }

    public function store(StoreSector $request)
    {
        $sector = new Sector();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo setor";
        $log .= "\nUsuário: " . Auth::user()->name;

        $sector->created_at = Carbon::now();
        $sector->name = $validatedData->name;
        $sector->description = $validatedData->description;
        $sector->active = $validatedData->active;

        $saved = $sector->save();
        $log .= "\nNovos dados: " . json_encode($sector, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar setor");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.setor.index')->with($params);
    }

    public function update($id, UpdateSector $request)
    {
        $sector = Sector::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de setor";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($sector, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $sector->updated_at = Carbon::now();
        $sector->name = $validatedData->name;
        $sector->description = $validatedData->description;
        $sector->active = $validatedData->active;

        $saved = $sector->save();
        $log .= "\nNovos dados: " . json_encode($sector, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar setor");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('coordenador.empresa.setor.index')->with($params);
    }
}
