<?php

namespace App\Http\Controllers\Admin;

use App\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeUserPassword;
use App\Http\Requests\Admin\DestroyUser;
use App\Http\Requests\Admin\StoreUser;
use App\Http\Requests\Admin\UpdateUser;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list');
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:user-changePassword', ['only' => ['changePassword']]);
    }

    public function index()
    {
        $users = User::all();

        return view('admin.user.index')->with(['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all()->where('name', '<>', 'company')->where('name', '<>', 'student')->sortBy('id');

        return view('admin.user.new')->with(['roles' => $roles]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if ($user->hasRole('company') || $user->hasRole('student')) {
            abort(404);
        }

        $roles = Role::all()->where('name', '<>', 'company')->where('name', '<>', 'student')->merge($user->roles)->sortBy('id');

        return view('admin.user.edit')->with(['user' => $user, 'roles' => $roles]);
    }

    public function editPassword($id)
    {
        $user = User::findOrFail($id);

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

        $saved = $user->save();
        $log .= "\nNovos dados: " . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $user->syncRoles([Role::findOrFail($validatedData->role)->name]);

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

        $saved = $user->save();
        $log .= "\nNovos dados: " . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $user->syncRoles([Role::findOrFail($validatedData->role)->name]);

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao salvar usuário");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('admin.usuario.index')->with($params);
    }

    public function destroy($id, DestroyUser $request)
    {
        $user = User::findOrFail($id);
        $params = [];

        $validatedData = (object)$request->validated();

        $log = "Exclusão de usuário";
        $log .= "\nUsuário: " . Auth::user()->name;
        $log .= "\nDados antigos: " . json_encode($user, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saved = $user->delete();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao excluir usuário");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Excluído com sucesso' : 'Erro ao excluir!';
        return redirect()->route('admin.usuario.index')->with($params);
    }

    public function updatePassword($id, ChangeUserPassword $request)
    {
        $user = Auth::user();
        $log = "Alteração de senha de usuário";
        $log .= "\nUsuário: {$user->name}";

        $params = [];

        $validatedData = (object)$request->validated();

        $user = User::findOrFail($id);
        $user->password = Hash::make($validatedData->password);
        $user->password_change_at = Carbon::now();

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
