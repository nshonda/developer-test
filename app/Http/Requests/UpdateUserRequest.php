<?php

namespace App\Http\Requests;

use App\Models\User;

class UpdateUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users,username,'.$this->request->get('username').',username',
            'email' => 'required|email|unique:users,email,'.$this->request->get('email').',email|max:200',
            'roles' => 'required|array|exists:roles,name',
            'avatar' => 'nullable|image',
            'password' => 'nullable|min:6'
        ];
    }

}
