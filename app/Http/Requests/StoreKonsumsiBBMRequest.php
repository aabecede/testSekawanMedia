<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreKonsumsiBBMRequest extends FormRequest
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
            'master_kendaraan_id' => [
                'required',
                Rule::exists('master_kendaraan', 'id'),
            ],
            'tanggal_isi_at' => [
                'required',
                'date',
            ],
            'total_liter' => [
                'required',
                'numeric',
                'gt:0'

            ],
            'total_harga' => [
                'required',
                'numeric',
                'gt:0'

            ],
            'bukti_struk' => [
                'required',
                'mimes:jpg,bmp,png,jpeg,pdf',
                'max:2200'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $warning = $validator->errors()->messages();
        throw new HttpResponseException(
            back()->withInput()->with('validator', $warning)
        );
    }
}
