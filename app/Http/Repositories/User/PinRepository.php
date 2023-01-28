<?php
namespace App\Http\Repositories\User;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;


class PinRepository {

    public function set_transaction_pin($data)
    {
        $user = User::find(auth()->guard('user-api')->user()->profileable_id);
        $user->transaction_pin = Hash::make($data['transaction_pin']);
        $user->completed_profile = $user->completed_profile < 2 ? $user->completed_profile + 1 : $user->completed_profile;
        $user->save();

        $profile = collect($user->profile);
        $user = collect($user);
        $merge = $user->merge($profile);

        return response()->json([
            "status" => true,
            "message" => "Transaction pin updated successfully",
            "profile" => $merge
        ], 200);
    }


    public function set_duress_pin($data)
    {
        $user = User::find(auth()->guard('user-api')->user()->profileable_id);
        $user->duress_pin = Hash::make($data['duress_pin']);
        $user->completed_profile = $user->completed_profile < 3 ? $user->completed_profile + 1 : $user->completed_profile;
        $user->save();

        $profile = collect($user->profile);
        $user = collect($user);
        $merge = $user->merge($profile);

        return response()->json([
            "status" => true,
            "message" => "Duress pin updated successfully",
            "profile" => $merge
        ], 200);
    }


    public function set_passcode($data)
    {
        $user = User::find(auth()->guard('user-api')->user()->profileable_id);
        $user->passcode = Hash::make($data['passcode']);
        $user->completed_profile = $user->completed_profile < 4 ? $user->completed_profile + 1 : $user->completed_profile;
        $user->save();

        $profile = collect($user->profile);
        $user = collect($user);
        $merge = $user->merge($profile);

        return response()->json([
            "status" => true,
            "message" => "Passcode updated successfully",
            "profile" => $merge
        ], 200);
    }

}

