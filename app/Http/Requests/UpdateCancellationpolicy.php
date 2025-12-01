<?php

namespace App\Http\Requests;

use App\Models\CancellationPolicy;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCancellationpolicy extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cancellation_policies');
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
                'required',
            ],
            'type' => [
                'required',
            ],
            'value' => [
                'required',
            ],
            'status' => [
                'required',
            ],
        
        ];
    }
}
