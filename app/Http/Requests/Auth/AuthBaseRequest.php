<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthBaseRequest extends FormRequest
{
    /**
     * username validation rule.
     * 
     * @var String
     * 
     */
    protected $name = 'required|confirmed|min:8';

    /**
     * email validation rule.
     * 
     * @var String
     * 
     */
    protected $email = 'required|confirmed|min:8';

    /**
     * password validation rule.
     * 
     * @var String
     * 
     */
    protected $password = 'required|confirmed|min:8';

    /**
     * password validation rule.
     * 
     * @var String
     * 
     */
    protected $password_confirmation = 'required|confirmed|min:8';

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
            //
        ];
    }
}