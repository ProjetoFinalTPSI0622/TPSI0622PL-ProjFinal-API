<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|max:255',
            'internalcode' => 'required|max:255',
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
             'name.required' => 'A name is required',
             'name.unique'  => 'A name is unique',
             'email.required' => 'An email is required',
             'email.unique' => 'An email must be unique',
             'email.max' => 'An email must be less than 255 characters',
             'password.required' => 'A password is required',
             'password.max' => 'A password must be less than 255 characters',
             'internalcode.required' => 'An internal code is required',
             'internalcode.max' => 'An internal code must be less than 255 characters',
         ];
     }
}
