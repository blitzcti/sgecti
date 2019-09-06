<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUser;
use App\Http\Requests\Admin\UpdateUser;
use App\Http\Requests\ChangeUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list');
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
        $roles = Role::all()->where('name', '<>', 'company')->merge($user->roles)->sortBy('id');

        return view('admin.user.edit')->with(['user' => $user, 'roles' => $roles]);
    }

    public function changePassword($id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('admin.user.index');
        }

        $user = User::findOrFail($id);

        // return view('admin.user.changePassword')->with(['user' => $user]);
        return view('auth.passwords.reset')->with(['user' => $user]);
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
        $user = User::findOrFail($id);
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
        $log .= "\nUsuário: " . Auth::user()->name;

        $params = [];

        $validatedData = (object)$request->validated();

        $user = User::findOrFail($id);
        $user->password = Hash::make($validatedData->password);

        $saved = $user->save();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar senha");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.usuario.index')->with($params);
    }
}
