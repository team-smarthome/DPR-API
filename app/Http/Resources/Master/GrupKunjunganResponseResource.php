<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class GrupKunjunganResponseResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'ketua_grup' => $this->ketua_grup ?? null,
      'nama_grup_pegawai' => $this->nama_grup_pegawai ?? null,
      'pegawai' => PegawaiResource::collection($this->pegawai) ?? [],
      'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d H:i:s') : null,
      'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->format('Y-m-d H:i:s') : null,
    ];
  }
}
