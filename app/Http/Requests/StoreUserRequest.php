<?php

namespace App\Http\Requests;

use App\Models\User;

class StoreUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'roles' => 'required|array|exists:roles,name',
            'avatar' => $this->request->has('avatar') ? 'nullable' : 'image',
            'password' => 'required|min:6',
        ];
    }
}
