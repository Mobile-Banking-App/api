<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "account_name" => ["required", "string", "max:191"],
            "account_number" => ["required", "numeric", "digits:10"],
            "pin" => ["required", "numeric", "digits:4"],
            "bank_name" => ["required", "string", "max:191"],
            "amount" => ["required", "numeric", "min:5"],
            "status" => ["required", "string", "in:successful,failed,pending"]
        ];
    }
}
