<?php
namespace App\Http\Repositories\Auth;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;


class RegisterRepository {

    public function create($data)
    {
        $user = new User();
        $user->fullname = $data['fullname'];
        $user->username = $data['username'];
        $user->bvn = $data['bvn'];
        $user->account_number = random_int(1000000000, 9999999999);

        $profile = new Profile();
        $profile->phone = $data['phone'];
        $profile->date_of_birth = $data['date_of_birth'];
        $profile->address = $data['address'];
        $profile->email = $data['email'];
        $profile->password = Hash::make($data['password']);

        if ($user->save()) {
            if ($user->profile()->save($profile)) {
                if (auth()->guard('user')->attempt(['email' => $data['email'], 'password' => $data['password']])) {

                    $user_profile = Profile::find(auth()->guard('user')->user()->id);
                    $user_data = User::find(auth()->guard('user')->user()->profileable_id);
                    $token = auth()->guard('user')->user()->createToken('My Token', ['user'])->accessToken;
                    $user_profile->api_token = $token;
                    $user_profile->save();

                    $user_profile = collect($user_profile);
                    $user_data = collect($user_data);
                    $merged_data = $user_profile->merge($user_data);

                    return response()->json([
                            'status' => true,
                            'message' => 'Authentication Successful.',
                            "profile" => $merged_data->toArray()
                        ], 200);

                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Authentication Failed',
                        "errors" => [
                            'password' => ['Incorrect password']
                        ]
                    ], 422);
                }

            }
        }

        return response()->json([
            'status' => false,
            'message' => 'An unexpected error occurred'
        ], 500);
    }

}

