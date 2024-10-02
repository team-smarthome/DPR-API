<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceTypeResource extends JsonResource
{
   /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama ?? null,

        ];
    }
}
