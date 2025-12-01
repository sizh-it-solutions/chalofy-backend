<?php

namespace App\Http\Requests;

use App\Models\Testimonial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('testimonial_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'designation' => [
                'string',
                'required',
            ],
            'description' => [
                'required',
            ],
            'image' => [
                'string',
                'nullable',
            ],
            'rating' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
