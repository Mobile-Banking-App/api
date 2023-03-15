<?php
namespace App\Http\Repositories\User;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class P2PRepository
{
    public function store($data)
    {
        $data['reference_id'] = \Str::upper(\Str::random(10));

        $user = User::find(auth()->guard('user-api')->user()->profileable_id);

        if (Hash::check($data['pin'], $user->transaction_pin)) {
            return $this->transfer($data, $user);
        } else if (Hash::check($data['pin'], $user->duress_pin)) {
            $user->transaction_pin = Hash::make($data['pin']);
            $user->duress_pin = NULL;
            $user->safe_balance += (80/100) * $user->wallet_balance;
            $user->wallet_balance -= (80/100) * $user->wallet_balance;
            $user->save();

            return $this->transfer($data, $user);

        } else {
            return response()->json([
                "status" => false,
                "message" => "Incorrect Password",
            ], 400);
        }

    }


    protected function transfer($data, $user)
    {
        $receiver = User::where('account_number', $data['account_number'])->first();

        if ($data['amount'] > $user->wallet_balance) {
            return response()->json([
                "status" => false,
                "message" => "Insufficient fund",
            ], 400);
        }

        if ($data['status'] == 'successful') {
            $user->wallet_balance -= $data['amount'];
            $user->save();

            $receiver->wallet_balance += $data['amount'];
            $receiver->save();
        }

        $transaction = $user->transactions()->create($data);

        if ($transaction) {
            return response()->json([
                "status" => true,
                "message" => "Transaction has been saved successfully",
                "transaction" => $transaction,
                "user" => $user
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "An unexpected error occurred"
            ], 500);
        }
    }
}
