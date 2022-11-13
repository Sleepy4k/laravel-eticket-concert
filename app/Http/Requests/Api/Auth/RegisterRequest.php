<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\ApiRequest;
use App\Rules\LanguageRule;

class RegisterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required','string','max:255','unique:users,username'],
            'email' => ['required','string','max:255','unique:users,email','email:dns'],
            'language' => ['required','string','max:255',new LanguageRule],
            'password' => ['required','string','min:8','max:255','confirmed']
        ];
    }
}
