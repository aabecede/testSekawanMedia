<?php

namespace App\Http\Requests;

use App\Models\MasterKantor;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateMasterKantorRequest extends FormRequest
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
            'region_id' => [
                'required',
                Rule::exists('master_region', 'id')
            ],
            'tipe_kantor' => [
                'required',
                Rule::in(MasterKantor::$tipeKantor),
            ],
            'nama' => [
                'required',
            ],
            'alamat' => [
                'required',
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
