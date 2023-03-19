<?php
namespace App\Http\Repositories\User;


use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Card;

class CardRepository
{
    public function generateCard($data)
    {
        $data['card_number'] = random_int(1000000000000000, 9999999999999999);
        $data['cvv'] = random_int(100, 999);
        $mm = random_int(1, 12);
        $data['expiry_date'] = $mm . '/25';
        $data['card_pin'] = Hash::make($data['card_pin']);
        $data['duress_pin'] = Hash::make($data['duress_pin']);


        $user = User::find(auth()->guard('user-api')->user()->profileable_id);

        if ($user->card()->count() > 0) {
            return response()->json([
                'status' => true,
                'message' => 'You already have a card',
                'card' => $user->card
            ], 200);
        }

        if ($user->card()->create($data)) {
            return response()->json([
                'status' => true,
                'message' => 'Card has been created successfully',
                'card' => $user->card
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'An unexpected error occured'
            ], 500);
        }
    }

    public function set_duress_pin($data)
    {

        $user = User::find(auth()->guard('user-api')->user()->profileable_id);

        if ($user->card()->update([
            'duress_pin' => Hash::make($data['duress_pin'])
        ])) {
            return response()->json([
                "status" => true,
                "message" => "Card duress pin updated successfully",
                "card" => $user->card
            ], 200);
        }
    }

    public function set_card_pin($data)
    {

        $user = User::find(auth()->guard('user-api')->user()->profileable_id);

        if ($user->card()->update([
            'card_pin' => Hash::make($data['card_pin'])
        ])) {
            return response()->json([
                "status" => true,
                "message" => "Card pin updated successfully",
                "card" => $user->card
            ], 200);
        }
    }


    public function delete($id)
    {
        $card = Card::find($id);

        if ($card) {
            if ($card->delete()) {
                return response()->json([
                    "status" => true,
                    "message" => "card deleted successfully",
                ], 200);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "card not found",
            ], 404);
        }

        return response()->json([
            "status" => false,
            "message" => "An unexpected error occurred",
        ], 500);
    }


}
