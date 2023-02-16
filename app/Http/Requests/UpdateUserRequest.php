<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $request = request();

        $rules = [
            'uuid' => [
                'required',
                Rule::exists('users', 'uuid'),
            ],
            'name' => ['required'],
            'email' => [
                'required',
                Rule::unique('users', 'email')
                ->using(function($q) use ($request){
                    $q->where('uuid', '!=', $request->uuid);
                }),
            ],
            'jabatan' => [
                'required',
                Rule::in(User::$enum_jabatan)
            ],
            'role' => [
                'required',
                Rule::in(User::$enum_role)
            ],
            'status' => [
                'required',
                Rule::in(User::$enum_status)
            ],
        ];

        if (!empty($request->master_region_id)) {
            $rules['master_region_id'] = [
                'required',
                Rule::exists('master_region', 'id'),
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
