<?php

namespace App\Http\Requests;

use App\Models\GeneralSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateGeneralSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('general_setting_edit');
    }

    public function rules()
    {
        return [
            'meta_key' => [
                'string',
                'required',
            ],
            'meta_value' => [
                'string',
                'required',
            ],
        ];
    }
}
