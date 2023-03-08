<?php
namespace App\Http\Repositories\User;

use App\Models\Transaction;

class TransactionRepository
{
    public function store($data)
    {
        $data['reference_id'] = \Str::upper(\Str::random(10));

        $transaction = Transaction::create($data);

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
