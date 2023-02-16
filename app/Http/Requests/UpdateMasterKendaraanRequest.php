<?php

namespace App\Http\Requests;

use App\Models\MasterKendaraan;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateMasterKendaraanRequest extends FormRequest
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
            'status_kendaraan' => [
                'required',
                Rule::in(MasterKendaraan::$status_kendaraan)
            ],
            'jenis_kendaraan' => [
                'required'
            ],
            'tanggal_beli_sewa_at' => [
                'required',
                'date '
            ],

            'nama' => [
                'required',
            ],
            'max_tangki' => [
                'required',
                'numeric',
                'gt:0'
            ],
            'current_km' => [
                'required',
                'numeric',
                'gt:0'
            ]
        ];
        $request = request();
        if (strtoupper($request->status_kendaraan) == 'SEWA') {
            $rules['agen_sewa'] = [
                'required'
            ];
            $rules['tanggal_jual_sewa_at'] = [
                'required',
                'date',
                'after:tanggal_beli_sewa_at'
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
