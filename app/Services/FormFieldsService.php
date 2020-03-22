<?php

namespace App\Services;

use App\Http\Requests\CreateFormFieldRequest;
use App\Models\FormField;

class FormFieldsService
{
    public static function createField(CreateFormFieldRequest $request)
    {
        $count = FormField::where('recruitment_id', $request->recruitment_id)->count();

        $field = FormField::make($request->validated());
        $field->order = $count;
        $field->save();

        return $field;
    }

    public static function updateField($request)
    {

    }

    public static function deleteField($fieldId)
    {
        $fieldId = FormField::findOrFail($fieldId);
        $fieldId->delete();

        //TODO: reorder remaing fields
    }
}
