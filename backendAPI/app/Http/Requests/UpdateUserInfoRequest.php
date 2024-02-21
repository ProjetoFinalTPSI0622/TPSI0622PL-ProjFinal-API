<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserInfoRequest extends FormRequest
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->has('birthday_date') && $this->isDateFormat('d-m-Y', $this->birthday_date)) {
            $this->merge([
                'birthday_date' => Carbon::createFromFormat('d-m-Y', $this->birthday_date)->toDateString(),
            ]);
        }
    }

    /**
     * Determine if the given value matches the given date format.
     *
     * @param  string  $format
     * @param  mixed  $value
     * @return bool
     */
    protected function isDateFormat($format, $value)
    {
        try {
            Carbon::createFromFormat($format, $value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
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
            'nif' => [
                'required',
                'regex:/^[0-9]{9}$/',
                Rule::unique('user_infos')->ignore($this->userInfo->user_id, 'user_id'),
            ],
            'birthday_date' => 'required|date',
            'gender_id' => 'nullable|integer|exists:genders,id',
            'phone_number' => ['nullable', 'regex:/^(\+\d{12}|\d{9})$/'],
            'address' => 'sometimes|max:255',
            'postal_code' => 'nullable|regex:/^\d{4}-\d{3}$/',
            'city' => 'sometimes|max:30',
            'district' => 'sometimes|max:30',
            'country_id' => 'nullable|integer|exists:countries,id',
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
            'user_id.required' => 'O user_id é obrigatório',
            'user_id.integer' => 'O user_id deve ser um número inteiro',
            'user_id.exists' => 'O user_id não existe',
            'class.max' => 'A class deve ter menos de 255 caracteres',
            'nif.required' => 'O nif é obrigatório',
            'nif.regex' => 'O nif deve ter 9 dígitos',
            'nif.unique' => 'O nif já existe',
            'birthday_date.required' => 'A data de nascimento é obrigatória',
            'birthday_date.date' => 'A data de nascimento deve ser uma data válida',
            'gender_id.integer' => 'O género deve ser um número inteiro',
            'gender_id.exists' => 'O género não existe',
            'phone_number.regex' => 'O número de telefone deve ter o formato +351123456789 ou 123456789',
            'address.max' => 'A morada deve ter menos de 255 caracteres',
            'postal_code.regex' => 'O código postal deve ter o formato 1234-123',
            'city.max' => 'A cidade deve ter menos de 30 caracteres',
            'district.max' => 'O distrito deve ter menos de 30 caracteres',
            'country_id.integer' => 'O país deve ser um número inteiro',
            'country_id.exists' => 'O país não existe',
        ];
    }
}
