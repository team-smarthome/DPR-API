<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'nama_device' => $this->nama_device,
      'zona_id' => $this->zona_id,
      'dtype' => $this->dtype,
      'nama_device_type' => $this->DeviceType->nama,
      'ip_address' => $this->ip_address,
      'mac_address' => $this->mac_address,
      'rtsp_url' => $this->rtsp_url,
    ];
  }
}
