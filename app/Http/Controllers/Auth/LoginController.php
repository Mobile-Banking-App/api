<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Repositories\Auth\LoginRepository;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $loginRequest = new LoginRequest;
        $validator = Validator::make($request->all(), $loginRequest->rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $login = new LoginRepository;
        return $login->login($request->all());

    }



    public function logout(Request $request)
    {
        if (auth()->check()) {
            if (auth()->guard('user-api')->user()->token()->revoke()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Logout successful',
                ], 200);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'An unexpected error occurred',
        ], 200);
    }

}
