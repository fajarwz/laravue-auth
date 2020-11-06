<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class LoginController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $isEmail        = User::where('email', $request->email)->first();
        $isPassword     = Hash::check($request->password, $isEmail->password);

        if(!$user || !$isPassword) {
            return response ([
                'success'   => false,
                'message'   => ['These credentials do not match our records.']
            ], 404);
        }

    }
}
