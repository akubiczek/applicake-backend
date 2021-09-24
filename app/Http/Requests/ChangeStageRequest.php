<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeStageRequest extends FormRequest
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
            'appointment_date' => [
                'nullable',
                'date',
            ],
            'delay_message_send' => [
                'required',
                'boolean',
            ],
            'delayed_message_date' => [
                'requiredIf:delay_message_send,1',
                'date',
            ],
            'candidate_id' => [
                'required',
                'integer',
                'exists:tenant.candidates,id',
            ],
            'stage_id' => [
                'required',
                'integer',
                'exists:tenant.stages,id',
            ],
        ];
    }
}
