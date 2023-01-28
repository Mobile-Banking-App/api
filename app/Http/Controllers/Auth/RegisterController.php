<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Repositories\Auth\RegisterRepository;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $registerRequest = new RegisterRequest;
        $validator = Validator::make($request->all(), $registerRequest->rules());

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()
            ], 422);
        }

        $register = new RegisterRepository;
        return $register->create($request->all());

    }
}
