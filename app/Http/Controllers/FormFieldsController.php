<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormFieldRequest;
use App\Http\Requests\FormFieldUpdateRequest;
use App\Models\FormField;
use App\Services\FormFieldsService;
use Illuminate\Http\Request;

class FormFieldsController
{
    public function create(CreateFormFieldRequest $request)
    {
        $field = FormFieldsService::createField($request);

        return response()->json($field, 201);
    }

    public function list(Request $request)
    {
        $fields = FormField::where('recruitment_id', $request->get('recruitment_id'))->orderBy('order')->get();

        return response()->json($fields, 200);
    }

    public function update(FormFieldUpdateRequest $request, $fieldId)
    {
        $field = FormFieldsService::updateField($fieldId, $request);

        return response()->json($field, 200);
    }

    public function delete($fieldId)
    {
        FormFieldsService::deleteField($fieldId);

        return response()->json(null, 200);
    }

    public function reorder($dragId, $dropId)
    {
        $response = FormFieldsService::reorder($dragId, $dropId);

        return response()->json($response, 200);
    }
}
