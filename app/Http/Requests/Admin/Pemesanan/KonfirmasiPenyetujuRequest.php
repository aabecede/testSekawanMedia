<?php

namespace App\Http\Requests\Admin\Pemesanan;

use App\Models\Pemesanan;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class KonfirmasiPenyetujuRequest extends FormRequest
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
        $status_penyetuju = Pemesanan::$status_penyetuju;
        $arr_status_penyetuju = array_keys($status_penyetuju);
        return [
            'status_penyetuju' => [
                'required',
                Rule::in($arr_status_penyetuju),
            ],
            'alasan_penyetuju' => [
                'required'
            ],
            'penyetuju_id' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'uuid' => [
                'required',
                Rule::exists('pemesanan', 'uuid')
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $warning = $validator->errors()->messages();
        $result = [
            'validator' => $warning,
            'text_validator' => parsingAlert($validator->errors()->first()),
        ];
        throw new HttpResponseException(
            (new \App\Http\Controllers\Controller())->errorJson($result)
        );
    }
}
