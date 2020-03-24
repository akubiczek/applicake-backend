<?php

namespace App\Services;

use App\Http\Requests\CreateFormFieldRequest;
use App\Http\Requests\FormFieldUpdateRequest;
use App\Models\FormField;
use Illuminate\Support\Facades\DB;

class FormFieldsService
{
    public static function createField(CreateFormFieldRequest $request)
    {
        $order = FormField::where('recruitment_id', $request->recruitment_id)->max('order');

        $field = FormField::make($request->validated());
        $field->order = $order + 1;
        $field->save();

        return $field;
    }

    public static function updateField($fieldId, FormFieldUpdateRequest $request)
    {
        $field = FormField::findOrFail($fieldId);
        $input = $request->validated();
        $field->fill($input)->save();

        //TODO: if ($field->wasChanged('order')) reorder remaing fields

        return $field;
    }

    public static function deleteField($fieldId)
    {
        $field = FormField::findOrFail($fieldId);
        $field->delete();

        DB::connection('tenant')->table('form_fields')->where('recruitment_id', $field->recruitment_id)->where('order', '>', $field->order)->decrement('order');
    }
}