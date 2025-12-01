<?php

namespace App\Http\Requests;

use App\Models\Slider;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSliderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('slider_edit');
    }

    public function rules()
    {
        return [
            'heading' => [
                'string',
                'max:100',
                'required',
            ],
            'subheading' => [
                'string',
                'max:100',
                'nullable',
            ],
            'image' => [
                'array',
                'required',
            ],
            'image.*' => [
                'required',
            ],
        ];
    }
}
