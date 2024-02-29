<?php

namespace App\Http\Requests\Api\Contacts\Fields;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'LIST_COLUMN_LABEL' => 'required|string',
            'USER_TYPE_ID' => 'required|string',
            'SETTINGS' => 'string',
            'LIST' => 'string',
            'MULTIPLE' => 'string|boolean',
            'member_id' => 'required|string|exists:App\Models\Setting,member_id',
        ];
    }

    public function messages(): array
    {
        return [
            'LIST_COLUMN_LABEL.required' => 'A LIST_COLUMN_LABEL is required',
            'LIST_COLUMN_LABEL.string' => 'A LIST_COLUMN_LABEL is string',
            'USER_TYPE_ID.required' => 'A USER_TYPE_ID is required',
            'USER_TYPE_ID.string' => 'A USER_TYPE_ID is string',
            'SETTINGS.string' => 'A SETTINGS is string',
            'LIST.string' => 'A LIST is string',
            'member_id.string' => 'A member_id must be string',
            'MULTIPLE.string' => 'A MULTIPLE must be 0 or 1',
            'MULTIPLE.boolean' => 'A MULTIPLE must be 0 or 1',
        ];
    }
}
