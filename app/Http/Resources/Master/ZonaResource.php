<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonaResource extends JsonResource
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
      'nama_zona' => $this->nama_instansi,
      'jenis_zona' => $this->jenis_zona,
      'lokasi_id' => $this->lokasi_id ?? null,
      'panjang' => $this->panjang ?? null,
      'lebar' => $this->lebar ?? null,
      'posisi_X' => $this->posisi_X ?? null,
      'posisi_Y' => $this->posisi_Y ?? null,
      'parent_id' => $this->parent_id ?? null,
      'jenis_restriksi' => $this->jenis_restriksi
    ];
  }
}
