<?php

namespace App\Http\Requests;

use App\Models\SpaceType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSpaceTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('space_type_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
