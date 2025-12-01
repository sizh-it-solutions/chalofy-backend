<?php

namespace App\Http\Requests;

use App\Models\RentalItemRule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateItemRulesRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('item_rule_edit');
    }

    public function rules()
    {
        return [
            'rule_name' => [
                'string',
                'required',
            ],
            'status' => [
                'required',
            ],
            'module' => [
                'required',
            ],
        ];
    }
}
