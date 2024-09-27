<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceTypeRequest 
{
    public function validate(Request $request)
    {
        $rules = [
            'nama' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('device_type', 'nama')->where(function ($query) {
                    return $query->whereRaw('LOWER(nama) = LOWER(?)', [request('nama')]);
                }),
                'regex:/^[a-zA-Z\s]*$/'
            ],
        ];


        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
