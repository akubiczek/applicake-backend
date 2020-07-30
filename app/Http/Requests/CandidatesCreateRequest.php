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
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'email',
                'string',
            ],
            'phone_number' => [
                'string',
            ],
            'recruitment_id' => [
                'required',
                'integer',
                'exists:tenant.recruitments,id'
            ],
            'comment' => [
                'string',
            ],
        ];
    }
}
