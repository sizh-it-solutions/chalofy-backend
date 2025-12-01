<?php

namespace App\Http\Requests;

use App\Models\Modern\{ItemFeatures};
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFeatureRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('feature_create');
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
