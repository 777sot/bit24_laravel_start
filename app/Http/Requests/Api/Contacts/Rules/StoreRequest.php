<?php

namespace App\Http\Requests\Api\Contacts\Rules;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'field_right' => 'required|string',
            'field_left' => 'required|string',
//            'rule_type' => 'required|string',
            'block_type' => 'required|string',
            'show' => 'string|boolean',
            'member_id' => 'required|string|exists:App\Models\Setting,member_id',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    public function messages(): array
    {
        return [
            'field_right.required' => 'A field_right is required',
            'field_right.string' => 'A field_right is string',
            'field_left.required' => 'A field_left is required',
            'field_left.string' => 'A field_left is string',
            'block_type.required' => 'A block_type is required',
            'block_type.string' => 'A block_type must be 1 or 2 or 3',
            'show.string' => 'A show must be 0 or 1',
            'show.boolean' => 'A show must be 0 or 1',
        ];
    }
}
