<?php

namespace App\Http\Controllers;

use App\Auth;
use App\Broker;
use App\Http\Requests\ChangeUserPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function editPassword()
    {
        if (config('broker.useSSO')) {
            $broker = new Broker;

            return redirect($broker->serverPasswordPage());
        } else {
            $user = Auth::user();

            return view('auth.passwords.change')->with(['user' => $user]);
        }
    }

    public function updatePassword(ChangeUserPassword $request)
    {
        $params = [];
        $validatedData = (object)$request->validated();

        $user = Auth::user();
        $log = "Alteração de senha de usuário";
        $log .= "\nUsuário: {$user->name}";

        $user->password = Hash::make($validatedData->password);
        $user->password_change_at = Carbon::now();

        $saved = $user->save();

        if ($saved) {
            Log::info($log);
        } else {
            Log::error("Erro ao alterar senha");
        }

        $params['saved'] = $saved;
        $params['message'] = ($saved) ? 'Salvo com sucesso' : 'Erro ao salvar!';

        return redirect()->route('home')->with($params);
    }
}
