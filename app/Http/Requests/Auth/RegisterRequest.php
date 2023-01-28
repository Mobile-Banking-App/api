<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'fullname' => ['required', 'string', 'max:191'],
            'username' => ['required', 'string', 'unique:users', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'phone' => ['required', 'numeric', 'unique:profiles'],
            'bvn' => ['required', 'numeric', 'unique:users'],
            'date_of_birth' => ['required', 'date'],
            'address' => ['required', 'string', 'max:1000'],
            'password' => ['required', 'string']
        ];
    }
}
