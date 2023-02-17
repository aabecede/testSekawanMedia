<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdatePemesananRequest extends FormRequest
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
        $rules = [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'master_kendaraan_id' => [
                'required',
                Rule::exists('master_kendaraan', 'id')
            ],
            'penyetuju' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'penyetuju2' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'driver' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'tanggal_keberangkatan_at' => [
                'required'
            ],
            'tanggal_pulang_at' => [
                'required'
            ],
            'keterangan' => [
                'required'
            ]
        ];
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {

        $warning = $validator->errors()->messages();
        throw new HttpResponseException(
            back()->withInput()->with('validator', $warning)
        );
    }
}
