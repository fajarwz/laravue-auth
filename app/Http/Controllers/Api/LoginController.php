<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $user           = User::where('email', $request->email)->first();

        $isEmail        = $user;
        $isPassword     = Hash::check($request->password, $user->password);

        if(!$isEmail || !$isPassword) {
            return response ([
                'success'   => false,
                'message'   => ['These credentials do not match our records.']
            ], 404);
        }

        $token       = $user->createToken('ApiToken')->plainTextToken;

        $response   = [
            'success'   => true,
            'user'      => $user,
            'token'     => $token
        ];

        return response($response, 201);

    }

    public function logout() {
        auth()->logout();
        return response()->json([
            'success'   => true
        ], 200);
    }
}
