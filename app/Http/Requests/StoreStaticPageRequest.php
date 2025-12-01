<?php

namespace App\Http\Requests;

use App\Models\StaticPage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStaticPageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('static_page_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
