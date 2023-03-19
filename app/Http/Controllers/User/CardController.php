<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Repositories\User\CardRepository;


class CardController extends Controller
{
    public function requestCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_pin' => 'required|numeric|digits:4',
            'duress_pin' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $cardRepo = new CardRepository;
        return $cardRepo->generateCard($request->all());
    }


    public function cardPin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_pin' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $cardRepo = new CardRepository;
        return $cardRepo->set_card_pin($request->all());
    }

    public function duressPin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'duress_pin' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error in validating data',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $cardRepo = new CardRepository;
        return $cardRepo->set_duress_pin($request->all());
    }

    public function destroy($id)
    {
        $cardRepo = new CardRepository;
        return $cardRepo->delete($id);
    }

}
