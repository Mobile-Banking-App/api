<?php
namespace App\Http\Repositories\User;

use App\Models\Transaction;
use App\Models\User;

class TransactionRepository
{
    public function store($data)
    {
        $data['reference_id'] = \Str::upper(\Str::random(10));

        $user = User::find(auth()->guard('user-api')->user()->profileable_id);
        $transaction = $user->transactions()->create($data);

        if ($transaction) {
            return response()->json([
                "status" => true,
                "message" => "Transaction has been saved successfully",
                "transaction" => $transaction
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "An unexpected error occurred"
            ], 500);
        }
    }

}
