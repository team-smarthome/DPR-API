<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class GrupVehiclePegawaiResource extends JsonResource
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
            'vehicle_id' => $this->vehicle_id ?? null,
            'pegawai_id' => $this->vehicle->first()->pegawai_id ?? null,
            'nip' => $this->vehicle->first()->pegawai->nip ?? null,
            'nama_pegawai' => $this->vehicle->first()->pegawai->nama_pegawai ?? null,
            'pengunjung_id' => $this->vehicle->first()->pengunjung_id ?? null,
            'nik' => $this->vehicle->first()->pengunjung->nik ?? null,
            'nama_pengunjung' => $this->vehicle->first()->pengunjung->nama_pengunjung ?? null,
            'nama_grup_vehicle_pegawai' => $this->nama_grup_vehicle_pegawai ?? null,

        ];
    }
}
