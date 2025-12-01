<?php

namespace App\Http\Requests;

use App\Models\AppUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAppUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('app_user_create');
    }

    public function rules()
    {
        return [
            'first_name' => [
                'string',
                'required',
            ],
            'middle' => [
                'string',
                'nullable',
            ],
            'last_name' => [
                'string',
                'nullable',
            ],
            'email' => [
                'required',
                
            ],
            'phone' => [
                'string',
                'required',
                
            ],
            'phone_country' => [
                'string',
                'nullable',
            ],
            'default_country' => [
                'string',
                'nullable',
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
