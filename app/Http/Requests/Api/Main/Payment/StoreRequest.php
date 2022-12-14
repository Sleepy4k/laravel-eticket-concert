<?php

namespace App\Http\Requests\Api\Main\Payment;

use App\Http\Requests\ApiRequest;

class StoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'concert_code' => ['required','string','max:255','exists:concerts,code'],
            'quantity' => ['required','numeric','min:1']
        ];
    }
}
