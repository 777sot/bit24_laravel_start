<?php

namespace App\Http\Requests\Api\Deal\Rules;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fields' => 'required|string',
            'rule' => 'required|string',
            'rule_type' => 'required|string',
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
            'fields.required' => 'A fields is required',
            'fields.string' => 'A fields is string',
            'rule.required' => 'A rule is required',
            'rule.string' => 'A rule is string',
            'rule_type.required' => 'A rule_type is required',
            'rule_type.string' => 'A rule_type must be 1 or 2 or 3',
            'show.string' => 'A show must be 0 or 1',
            'show.boolean' => 'A show must be 0 or 1',
        ];
    }
}
