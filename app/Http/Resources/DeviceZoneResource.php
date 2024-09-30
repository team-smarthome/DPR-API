<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceZoneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'zona_id' => $this->zona_id,
            'device_id' => $this->device_id,
            'point_X' => $this->point_X,
            'point_Y' => $this->point_Y,
        ];
    }
}
