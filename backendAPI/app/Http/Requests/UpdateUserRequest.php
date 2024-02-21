<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id . '|max:255',
            'internalcode' => 'required|max:255',
            'role' => 'required|integer|exists:roles,id'
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
            'name.max'  => 'O nome deve ter menos de 255 caracteres',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email deve ser um email válido',
            'email.unique' => 'O email já existe',
            'email.max' => 'O email deve ter menos de 255 caracteres',
            'internalcode.required' => 'O código interno é obrigatório',
            'internalcode.max' => 'O código interno deve ter menos de 255 caracteres',
            'role.required' => 'O role é obrigatório',
            'role.integer' => 'O role deve ser um número inteiro',
            'role.exists' => 'O role não existe',
        ];
    }
}
