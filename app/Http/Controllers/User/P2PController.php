<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\TransactionRequest;
use App\Http\Repositories\User\P2PRepository;

class P2PController extends Controller
{

    public function userData($number)
    {
        $user = User::where('account_number', $number)->first();

        if ($user) {
            return response()->json([
                "status" => true,
                "message" => "User found",
                "transactions" => $user
            ], 200);
        } else {
            return response()->json([
                "status" => true,
                "message" => "User not found",
            ], 404);
        }
    }


    public function store(Request $request)
    {
        $transactionRequest = new TransactionRequest;
        $validator = \Validator::make($request->all(), $transactionRequest->rules());

        if($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation error",
                "errors" => $validator->errors()->all()
            ], 422);
        }

        $p2pRepo = new P2PRepository;
        return $p2pRepo->store($request->all());
    }

    public function complete(Request $request, $transactionId)
    {
        $validator = \Validator::make($request->all(), [
            'code' => 'required|exists:otps,code|numeric|digits:6',
        ]);


        if($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Validation error",
                "errors" => $validator->errors()->all()
            ], 422);
        }

        $p2pRepo = new P2PRepository;
        return $p2pRepo->complete($request->all(), $transactionId);
    }

}
