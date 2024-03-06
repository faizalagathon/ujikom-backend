<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrasiRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $request->validated();
        $user = User::where('username', $request->username)->first();

        return response()->json(['status' => true, 'message' => 'Berhasil Login', 'dataUser' => $user]);
    }

    public function registrasi(UserRegistrasiRequest $request)
    {
        User::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Registrasi'
        ]);
    }
}
