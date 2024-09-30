<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class DeviceZoneRequest 
{
    public function validate(Request $request)
    {
        $rules = [
            'device_id' => 'required|string|max:255',
            'zona_id' => 'required|string|max:255',
            'point_X' => 'required|max:255',
            'point_Y' => 'required|max:255'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
