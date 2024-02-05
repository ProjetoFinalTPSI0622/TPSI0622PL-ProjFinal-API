<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentStoreRequest extends FormRequest
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
            'comment_type' => 'sometimes|exists:comment_types,id',
            'comment_body' => 'required|string|max:255',
            'ticket_id' => 'required|exists:tickets,id'
            ];
    }

    public function messages()
    {
        return [
            'comment_type.exists' => 'Comment type does not exist',
            'comment_body.required' => 'Comment body is required',
            'comment_body.string' => 'Comment body must be a string',
            'comment_body.max' => 'Comment body must be more than 255 characters',
            'ticket_id.required' => 'Ticket ID is required',
            'ticket_id.exists' => 'Ticket ID does not exist'
        ];
    }
}
