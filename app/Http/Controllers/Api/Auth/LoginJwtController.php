<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginJwtRequest;

class LoginJwtController extends Controller
{
    public function login(LoginJwtRequest $request)
    {

        $credentials = $request->all(['email', 'password']);

        if(!$token = auth('api')->attempt($credentials)){
            $message = new ApiMessage('Unauthorized');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $token
        ]);

    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout successfully!'], 200);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json([
            'token' => $token
        ]);

    }
}
