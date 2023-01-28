<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\User\PinRepository;


class PinController extends Controller
{
    public function transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_pin' => 'required|numeric|digits:4',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()
            ], 422);
        }

        $pin = new PinRepository;
        return $pin->set_transaction_pin($request->all());
    }


    public function duress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'duress_pin' => 'required|numeric|digits:4',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()
            ], 422);
        }

        $pin = new PinRepository;
        return $pin->set_duress_pin($request->all());
    }


    public function passcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|numeric|digits_between:4,6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()
            ], 422);
        }

        $pin = new PinRepository;
        return $pin->set_passcode($request->all());
    }
}
