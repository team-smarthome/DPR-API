<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class SmartLockerCompartmentResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'number' => $this->number,
      'is_available' => $this->is_available,
      'qr_image' => $this->qr_image
    ];
  }
}
