<?php

namespace App\Http\Controllers;

use App\Sector;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::all();
        return view('coordinator.company.sector.index')->with(['sectors' => $sectors]);
    }

    public function getAjax()
    {
        $sectors = Sector::all();
        return response()->json(['sectors' => $sectors]);
    }

    public function new()
    {
        return view('coordinator.company.sector.new');
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('coordenador.empresa.setor.index');
        }

        $sector = Sector::findOrFail($id);

        return view('coordinator.company.sector.edit')->with(['sector' => $sector]);
    }

    public function save(Request $request)
    {
        $sector = new Sector();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'name' => 'required|max:50',
                'description' => '',
                'active' => 'required|boolean'
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $sector = Sector::all()->find($id);

                $sector->updated_at = Carbon::now();
            } else { // New
                $sector->created_at = Carbon::now();
            }

            $sector->nome = $validatedData->name;
            $sector->descricao = $validatedData->description;
            $sector->ativo = $validatedData->active;

            $saved = $sector->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('coordenador.empresa.setor.index')->with($params);
    }

    public function saveAjax(Request $request)
    {
        $sector = new Sector();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = Validator::make($request->all(), [
                'name' => 'required|max:50',
                'description' => '',
                'active' => 'required|boolean'
            ]);

            if ($validatedData->fails()) {
                return response()->json(['errors' => $validatedData->errors()->all()]);
            }

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $sector = Sector::all()->find($id);

                $sector->updated_at = Carbon::now();
            } else { // New
                $sector->created_at = Carbon::now();
            }

            $sector->nome = $request->input('name');
            $sector->descricao = $request->input('description');
            $sector->ativo = $request->input('active');

            $saved = $sector->save();

            $params['saved'] = $saved;
        }

        return response()->json($params);
    }
}
