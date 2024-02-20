<?php

namespace App\Http\Requests\Api\Leads\Dependency;

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
            'list_field_id' => 'required|string|exists:list_fields,id',
            'field_id' => 'required|string|exists:fields,id',
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
            'list_field_id.required' => 'A list_field_id is required',
            'list_field_id.string' => 'A list_field_id is string',
            'field_id.required' => 'A field_id is required',
            'field_id.string' => 'A field_id is string',
        ];
    }
}
