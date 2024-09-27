<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceRequest
{
    public function validate(Request $request)
    {
        $rules = [
            'nama_device' => 'required|string|max:255',
            'zona_id' => 'required|string|max:255',
            'dtype' => 'required|string|max:255',
            'ip_address' => 'required|string|max:255',
            'mac_address' => 'required|string|max:255',
            'rtsp_url' => 'required|string|max:255'
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

}
