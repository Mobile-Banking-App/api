<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\TransactionRequest;
use App\Http\Repositories\User\TransactionRepository;


class TransactionController extends Controller
{
    public function index()
    {

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

        $transactionRepository = new TransactionRepository;
        return $transactionRepository->store($request->all());
    }
}
