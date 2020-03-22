<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFormFieldRequest;
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
        $fields = FormField::where('recruitment_id', $request->get('recruitment_id'))->get();
        return response()->json($fields, 200);
    }

    public function update(Request $request, $fieldId)
    {
        $field = FormFieldsService::updateField($request);
        return response()->json($field, 200);
    }

    public function delete($fieldId)
    {
        FormFieldsService::deleteField($fieldId);
        return response()->json(null, 200);
    }
}
