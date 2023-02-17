<?php

namespace App\Http\Requests\Admin\MaserData;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PemesananDriverAvailAbleRequest extends FormRequest
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
            'tanggal_berangkat' => [
                'required', 'date'
            ],
            'tanggal_pulang' => [
                'required',
                'date',
                'after:tanggal_berangkat'
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $warning = $validator->errors()->messages();
        $result = [
            'validator' => $warning
        ];
        throw new HttpResponseException(
            (new \App\Http\Controllers\Controller())->errorJson($result)
        );
    }
}
