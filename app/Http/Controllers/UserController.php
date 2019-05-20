<?php

namespace App\Http\Controllers;

use App\Rules\CurrentPassword;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list');
        $this->middleware('permission:user-create', ['only' => ['new', 'save']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'save']]);
    }

    public function index()
    {
        $users = User::all();

        return view('admin.user.index')->with(['users' => $users]);
    }

    public function new()
    {
        $roles = Role::all();

        return view('admin.user.new')->with(['roles' => $roles]);
    }

    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('admin.user.index');
        }

        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.user.edit')->with(['user' => $user, 'roles' => $roles]);
    }

    public function changePassword($id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('admin.user.index');
        }

        $user = User::findOrFail($id);

        return view('admin.user.changePassword')->with(['user' => $user]);
    }

    public function save(Request $request)
    {
        $user = new User();
        $params = [];

        if (!$request->exists('cancel')) {
            if ($request->exists('id')) { // Edit
                $id = $request->input('id');
                $user = User::all()->find($id);

                $validatedData = (object)$request->validate([
                    'name' => 'required|max:30',
                    'email' => 'required|max:30',
                    'role' => 'required|numeric|min:1'
                ]);

                $user->updated_at = Carbon::now();
            } else { // New
                $validatedData = (object)$request->validate([
                    'name' => 'required|max:30',
                    'email' => 'required|max:30|unique:users,email',
                    'password' => 'required|min:8',
                    'role' => 'required|numeric|min:1'
                ]);

                $user->created_at = Carbon::now();
                $user->password = Hash::make($validatedData->password);
            }

            $user->name = $validatedData->name;
            $user->email = $validatedData->email;
            $user->syncRoles([Role::findOrFail($validatedData->role)->name]);

            $saved = $user->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.usuario.index')->with($params);
    }

    public function savePassword(Request $request)
    {
        $params = [];

        if (!$request->exists('cancel')) {
            $id = $request->input('id');
            $user = User::all()->find($id);

            $validatedData = (object)$request->validate([
                'old_password' => new CurrentPassword,
                'password' => 'required|confirmed|min:8',
            ]);

            $user->updated_at = Carbon::now();

            $user->password = Hash::make($validatedData->password);

            $saved = $user->save();

            $params['saved'] = $saved;
            $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';
        }

        return redirect()->route('admin.usuario.index')->with($params);
    }
}
