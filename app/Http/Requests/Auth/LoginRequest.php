<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginRequest
{
    public function validate(Request $request)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string',
        ];

        $validator = app('validator')->make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
