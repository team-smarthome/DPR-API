<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrupPegawaiResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ketua_grup' => $this->ketua_grup ?? null,
            'nama_grup_pegawai' => $this->nama_grup_pegawai ?? null
        ];
    }
}
