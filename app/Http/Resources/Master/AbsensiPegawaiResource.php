<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AbsensiPegawaiResource extends JsonResource
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
      'pegawai' => $this->pegawai,
      'image_url' => $this->image_url,
      'waktu_masuk' => $this->waktu_masuk,
      'waktu_keluar' => $this->waktu_selesai,
      'keterangan' => $this->keterangan,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
