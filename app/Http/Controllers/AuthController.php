<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        try {
            $validateUser = Validator::make(
                $r->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'error' => true,
                    'msg' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($r->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email e/ou senha incorretos.',
                ], 401);
            }

            $user = User::where('email', $r->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout(Request $r)
    {
        $user = User::where('email', $r->email)->first();

        $user->tokens()->delete();
    }
}
