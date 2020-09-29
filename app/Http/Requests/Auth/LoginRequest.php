<?php

namespace App\Http\Requests\Auth;

class LoginRequest extends AuthBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'bail|required|string|email',
            'password' => 'required|string'
        ];
    }
}
