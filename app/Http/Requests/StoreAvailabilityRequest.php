<?php

namespace App\Http\Requests;

use App\Models\Availability;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAvailabilityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('availability_create');
    }

    public function rules()
    {
        return [
            'quantity' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
