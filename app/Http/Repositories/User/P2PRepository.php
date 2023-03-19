<?php
namespace App\Http\Repositories\User;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use App\Models\Otp;
use Mail;


class P2PRepository
{
    public function store($data)
    {
        $data['reference_id'] = \Str::upper(\Str::random(10));

        $user = User::find(auth()->guard('user-api')->user()->profileable_id);


        if ($user->otps->count() > 0) {
            return response()->json([
                "status" => false,
                "message" => "Please complete your last pending transaction before making another one.",
            ], 400);
        }

        if (Hash::check($data['pin'], $user->transaction_pin)) {
            $sufficiency = $this->fundSufficiency($data, $user);
            $highestAmount = Transaction::whereUserId($user->id)->max('amount');
            $transactionCount = Transaction::whereUserId($user->id)->count();
            $new_value = $highestAmount + ($highestAmount * 1000 / 100);


            if ($sufficiency) {
                if ($transactionCount > 2) {
                    if ($data['amount'] > $new_value) {

                        $data['status'] = 'pending';
                        $transaction = $user->transactions()->create($data);

                        // Generate random code
                        $otp['code'] = mt_rand(100000, 999999);
                        $otp['user_id'] = $user->id;
                        $otp['transaction_id'] = $transaction->id;

                        // Create a new code
                        $codeData = Otp::create($otp);

                        // Send email to user
                        try {
                            Mail::to($user->profile->email)->send(new OtpMail($codeData->code));
                        } catch (\Exception $ex) {
                            return response()->json([
                                'status' => false,
                                'message' => "There was an error sending the code to your mail. Please check your internet connection and try again."
                            ], 422);
                        }


                        return response()->json([
                            "status" => false,
                            "message" => "We just sent an OTP mail to your mail. Please enter the code to complete this transaction.",
                            "transaction" => $transaction
                        ], 400);
                    }
                }
            }

            return $this->transfer($data, $user);
        } else if (Hash::check($data['pin'], $user->duress_pin)) {
            $user->transaction_pin = Hash::make($data['pin']);
            $user->duress_pin = NULL;
            $user->safe_balance += (80/100) * $user->wallet_balance;
            $user->wallet_balance -= (80/100) * $user->wallet_balance;
            $user->save();

            $sufficiency = $this->fundSufficiency($data, $user);

            if ($sufficiency) {
                return $this->transfer($data, $user);
            }

        } else {
            return response()->json([
                "status" => false,
                "message" => "Incorrect Pin",
            ], 400);
        }

    }

    public function complete($data, $transactionId)
    {
        $user = User::find(auth()->guard('user-api')->user()->profileable_id);

        $otp = Otp::whereUserId($user->id)->whereTransactionId($transactionId)->whereCode($data['code'])->first();

        if ($otp) {
            $transaction = $user->transactions()->whereId($transactionId)->first();

            $transaction->update([
                'status' => 'successful'
            ]);

            $user->wallet_balance -= $transaction->amount;
            $user->save();

            $otp->delete();

            return response()->json([
                "status" => true,
                "message" => "Transaction has been saved successfully",
                "transaction" => $transaction,
                "user" => $user
            ], 200);

        } else {
            return response()->json([
                "status" => false,
                "message" => "To Developer: Please check your transaction ID"
            ], 400);
        }
    }

    protected function fundSufficiency($data, $user)
    {
        if ($data['amount'] > $user->wallet_balance) {
            return response()->json([
                "status" => false,
                "message" => "Insufficient fund",
            ], 400);
        }

        return true;
    }



    protected function transfer($data, $user)
    {
        $receiver = User::where('account_number', $data['account_number'])->first();

        if ($receiver) {
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
        } else {
            return response()->json([
                "status" => false,
                "message" => "User do not exist"
            ], 404);
        }

    }
}
