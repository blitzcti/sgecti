<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeUserPassword;
use App\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {

    }

    public function changeUserPassword()
    {
        $user = Auth::user();

        return view('auth.passwords.change')->with(['user' => $user]);
    }

    public function savePassword($id, ChangeUserPassword $request)
    {
        $params = [];
        $validatedData = (object)$request->validated();

        $log = "Alteração de senha de usuário";

        $user = Auth::user();
        $user->password = Hash::make($validatedData->password);

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
