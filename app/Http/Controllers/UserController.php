<?php

namespace App\Http\Controllers;

use App\User;
use App\UserGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

    }

    public function new()
    {
        $groups = UserGroup::all();

        return view('admin.user.new')->with(['groups' => $groups]);
    }

    public function edit($id)
    {

    }

    public function save(Request $request)
    {
        $user = new User();
        $params = [];

        if (!$request->exists('cancel')) {
            $validatedData = (object)$request->validate([
                'name' => 'required|max:30',
                'email' => 'required|max:30|unique:users,email',
                'password' => 'required|min:8',
                'group' => 'required|numeric|min:1'
            ]);

            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $user = User::all()->find($id);

                $user->updated_at = Carbon::now();
            } else { // New
                $user->created_at = Carbon::now();

                $user->name = $validatedData->name;
                $user->email = $validatedData->email;
                $user->password = Hash::make($validatedData->password);
                $user->id_group = $validatedData->group;

                $saved = $user->save();

                $params['saved'] = $saved;
                $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
            }
        }

        return redirect()->route('admin.usuario.index')->with($params);
    }
}
