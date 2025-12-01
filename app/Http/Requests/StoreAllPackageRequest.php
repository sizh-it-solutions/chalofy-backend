<?php

namespace App\Http\Requests;

use App\Models\AllPackage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAllPackageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('all_package_create');
    }

    public function rules()
    {
        return [
            'package_name' => [
                'string',
                'required',
            ],
            'package_total_day' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'package_price' => [
                'required',
            ],
            'status' => [
                'required',
            ],
            'max_item' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
