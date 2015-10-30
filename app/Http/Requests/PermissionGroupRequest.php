<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PermissionGroupRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}