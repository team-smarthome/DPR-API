<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class KunjunganRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Define your validation rules here
        ];
    }
}
