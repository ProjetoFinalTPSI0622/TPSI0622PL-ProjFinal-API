<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TicketCreateRequest extends FormRequest
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
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'priority' => 'required|exists:priorities,id',
                'category' => 'required|exists:categories,id',
            ];
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.string' => 'A title must be a string',
            'title.max' => 'A title must be less than 255 characters',
            'description.required' => 'A description is required',
            'description.string' => 'A description must be a string',
            'description.max' => 'A description must be less than 1000 characters',
            'priority.required' => 'A priority is required',
            'priority.exists' => 'The priority must be a valid priority',
            'category.required' => 'A category is required',
            'category.exists' => 'The category must be a valid category',
        ];
    }
}
