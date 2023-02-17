<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateJadwalServiceRequest extends FormRequest
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
            'master_kendaraan_id' => [
                'required',
                Rule::exists('master_kendaraan', 'id')
            ],
            'tanggal_service_at' => [
                'required',
                'date'
            ],
            'keterangan' => [
                'required',
            ],
        ];

        if(request()->has('bukti_struk')){
            $rules['bukti_struk'] = [
                'mimes:jpg,bmp,png,jpeg,pdf',
                'max:2200'
            ];
        }

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
