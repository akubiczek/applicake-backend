<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatesCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => [
                'required',
                'exists:tenant.sources,key',
            ],
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
            ],
            'phone_number' => [
                'required',
                'string',
            ],
            'additional_info' => [
                'nullable',
                'string',
            ],
            'future_agreement' => [
                'boolean',
            ]
        ];
    }
}
