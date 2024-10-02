<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'pegawai_id' => $this->pegawai_id ?? null,
            'nip' => $this->nip ?? null,
            'nama_pegawai' => $this->nama_pegawai ?? null,
            'pengunjung_id' => $this->pengunjung_id ?? null,
            'nik' => $this->pengunjung->nik ?? null,
            'nama_pengunjung' => $this->pengunjung->nama_pengunjung ?? null,
            'plat_nomor' => $this->plat_nomor ?? null,
            'image_url' => $this->image_url ?? null,
            'grup_vehicle_pegawai_id' => $this->grup_vehicle_pegawai_id ?? null,
            'ketua_grup' => $this->grupVehiclePegawai->ketua_grup ?? null,
            'nama_grup_vehicle_pegawai' => $this->grupVehiclePegawai->nama_grup_vehicle_pegawai ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
