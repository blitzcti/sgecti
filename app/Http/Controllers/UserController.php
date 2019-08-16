<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserPassword;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\User;
use App\Rules\CurrentPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list', ['except' => ['changeCUserPassword', 'savePassword']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-changePassword', ['only' => ['changePassword']]);
    }

    public function index()
    {
        $users = User::all();

        return view('admin.user.index')->with(['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all()->where('name', '<>', 'company')->sortBy('id');

        return view('admin.user.new')->with(['roles' => $roles]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all()->where('name', '<>', 'company')->sortBy('id');

        return view('admin.user.edit')->with(['user' => $user, 'roles' => $roles]);
    }

    public function changePassword($id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('admin.user.index');
        }

        $user = User::findOrFail($id);

        return view('admin.user.changePassword')->with(['user' => $user]);
    }

    public function changeCUserPassword()
    {
        $user = Auth::user();

        return view('admin.user.changePassword')->with(['user' => $user]);
    }

    public function store(StoreUser $request)
    {
        $user = new User();
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Novo usuário";
        $log .= "\nUsuário: " . Auth::user()->name;

        $user->name = $validatedData->name;
        $user->email = $validatedData->email;
        $user->phone = $validatedData->phone;
        $user->password = Hash::make($validatedData->password);
        $user->syncRoles([Role::findOrFail($validatedData->role)->name]);

        $log .= "\nNovos dados: " . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $user->save();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar usuário");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.usuario.index')->with($params);
    }

    public function update($id, UpdateUser $request)
    {
        $user = User::all()->find($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Alteração de usuário";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $user->name = $validatedData->name;
        $user->email = $validatedData->email;
        $user->phone = $validatedData->phone;
        $user->syncRoles([Role::findOrFail($validatedData->role)->name]);

        $saved = $user->save();
        $log .= "\nNovos dados: " . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar usuário");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.usuario.index')->with($params);
    }

    public function savePassword($id, ChangeUserPassword $request)
    {
        $log = "Alteração de senha de usuário";
        if (Auth::user()->isAdmin()) {
            $user = User::all()->find($id);
            $log .= "\nUsuário: " . Auth::user()->name;
        } else {
            $user = Auth::user();
        }

        $params = [];

        $validatedData = (object)$request->validated();

        $user->password = Hash::make($validatedData->password);

        $saved = $user->save();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar configuração do sistema");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.usuario.index')->with($params);
        } else {
            return redirect()->route('home')->with($params);
        }
    }
}
