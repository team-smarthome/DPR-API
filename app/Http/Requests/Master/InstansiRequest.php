<?php

namespace App\Http\Requests\Master;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InstansiRequest
{
    public function validate(Request $request)
    {
        $request->merge([
            'nama_instansi' => trim($request->input('nama_instansi')),
        ]);

        $rules = [
            'nama_instansi' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('instansi', 'nama_instansi')->where(function ($query) {
                    return $query->whereRaw('LOWER(nama_instansi) = LOWER(?)', [request('nama_instansi')]);
                }),
                'regex:/^[a-zA-Z\s]*$/'
            ],
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}

