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
        $data = [
            'id' => $this->id,
            'plat_nomor' => $this->plat_nomor ?? null,
            'image_url' => $this->image_url ?? null,
            'grup_vehicle_pegawai_id' => $this->grup_vehicle_pegawai_id ?? null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        if ($this->pegawai_id) {
            $data['pegawai_id'] = $this->pegawai_id ?? null;
            $data['nip'] = $this->pegawai->nip ?? null;
            $data['nama_pegawai'] = $this->pegawai->nama_pegawai ?? null;

            if (!$this->pengunjung_id) {
                return $data;
            }
        }

        if ($this->pengunjung_id) {
            $data['pengunjung_id'] = $this->pengunjung_id ?? null;
            $data['nik'] = $this->pengunjung->nik ?? null;
            $data['nama_pengunjung'] = $this->pengunjung->nama_pengunjung ?? null;
        }

        if ($this->grupVehiclePegawai) {
            $data['ketua_grup'] = $this->grupVehiclePegawai->ketua_grup ?? null;
            $data['nama_grup_vehicle_pegawai'] = $this->grupVehiclePegawai->nama_grup_vehicle_pegawai ?? null;
        }

        return $data;
    }
}
