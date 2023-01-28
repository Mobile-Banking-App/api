<?php
namespace App\Http\Repositories\Auth;

use App\Models\User;
use App\Models\Profile;
use App\Models\Admin;


class LoginRepository {

    public function login($data)
    {

        $profile = Profile::where('email', $data['email'])->first();

        if ($profile) {

            if ($profile->profileable_type === 'user') {

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

            } else if ($profile->profileable_type === 'admin') {

                if (auth()->guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {

                    $user_profile = Profile::find(auth()->guard('admin')->user()->id);
                    $user_data = Admin::find(auth()->guard('admin')->user()->profileable_id);
                    $token = auth()->guard('admin')->user()->createToken('My Token', ['admin'])->accessToken;
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

        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication Failed',
                "errors" => [
                    'email' => ['Email not found']
                ]
            ], 422);
        }

    }


}
