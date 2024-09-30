<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class LokasiResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'nama_lokasi' => $this->nama_lokasi,
      'latitude' => $this->latitude,
      'longitude' => $this->longitude
    ];
  }
}
