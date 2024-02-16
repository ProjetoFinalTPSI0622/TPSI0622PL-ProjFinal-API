<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class UserInfoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->user()->hasRole('admin');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'class' => 'sometimes|max:255',
            'nif' => 'required|unique:user_infos|size:9',
            'birthday_date' => 'required|date',
            'gender' => 'nullable|integer|exists:genders,id',
            'phone_number' => 'sometimes|max:13',
            'address' => 'sometimes|max:255',
            'postal_code' => 'sometimes|max:8',
            'city' => 'sometimes|max:30',
            'district' => 'sometimes|max:30',
            'country' => 'nullable|integer|exists:countries,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
}
