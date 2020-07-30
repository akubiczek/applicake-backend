<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatesApplyRequest extends FormRequest
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
//            'key' => [
//                'required',
//                'exists:tenant.sources,key',
//            ],
            'name' => [
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
//            'future_agreement' => [
//                'boolean',
//            ]
        ];
    }
}
