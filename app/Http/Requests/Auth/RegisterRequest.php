<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends AuthBaseRequest
{
    protected $email = 'bail|required|unique:users';

    /**
     * password validation rule.
     * 
     * @var String
     * 
     */
    protected $password = 'bail|required|confirmed|min:8';

    /**
     * password validation rule.
     * 
     * @var String
     * 
     */
    protected $password_confirmation = 'bail|required|min:8';
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation
        ];
    }
}
