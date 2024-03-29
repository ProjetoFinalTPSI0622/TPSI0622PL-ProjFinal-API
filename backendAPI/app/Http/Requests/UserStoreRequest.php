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
        return Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:60|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:255',
            'internalcode' => 'required|max:255',
            'role_id' => 'sometimes|integer|exists:roles,id'
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
            'name.required' => 'O nome é obrigatório',
            'name.max' => 'O nome deve ter menos de 60 caracteres',
            'name.regex' => 'O nome deve conter apenas letras e espaços',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email deve ser um email válido',
            'email.unique' => 'O email já existe',
            'email.max' => 'O email deve ter menos de 255 caracteres',
            'password.required' => 'A password é obrigatória',
            'password.max' => 'A password deve ter menos de 255 caracteres',
            'internalcode.required' => 'O código interno é obrigatório',
            'internalcode.max' => 'O código interno deve ter menos de 255 caracteres',
        ];
    }
}
