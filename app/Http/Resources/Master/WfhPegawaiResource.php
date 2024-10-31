<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WfhPegawaiResource extends JsonResource
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
      'nama_wfh_pegawai' => $this->nama_wfh_pegawai,
      'pegawai' => $this->pegawai,
      'image_url' => $this->image_url,
      'waktu_mulai' => $this->waktu_mulai,
      'waktu_selesai' => $this->waktu_selesai,
      'keterangan' => $this->keterangan,
      'status' => $this->status,
      'approved_by_id' => $this->approved_by_id ?? null,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at
    ];
  }
}
