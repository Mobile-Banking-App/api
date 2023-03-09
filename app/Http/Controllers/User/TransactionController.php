<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\TransactionRequest;
use App\Http\Repositories\User\TransactionRepository;
use App\Models\Transaction;
use App\Models\User;


class TransactionController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->guard('user-api')->user()->profileable_id);
        $transactions = $user->transactions;
        return response()->json([
            "status" => true,
            "message" => "Transaction fetched successfully",
            "transactions" => $transactions
        ], 200);
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


    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) {
            return response()->json([
                "status" => true,
                "message" => "Transaction deleted successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "An unexpected error occurred!"
            ], 500);
        }
    }


}
