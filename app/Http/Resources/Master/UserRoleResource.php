<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class UserRoleResource extends JsonResource
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
            'nama_role' => $this->nama_role ?? null,

        ];
    }
}
