<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUsersRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $warning = $validator->errors()->all();
        $message = parsingAlert($warning);
        $response = (new \App\Http\Controllers\Controller())->errorJson(
            $result = [],
            $message
        );
        throw new HttpResponseException($response);
    }
}
