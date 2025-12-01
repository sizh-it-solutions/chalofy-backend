<?php

namespace App\Http\Requests;

use App\Models\Amenity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('feature_edit');
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
            'icon' => [
                'required',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
