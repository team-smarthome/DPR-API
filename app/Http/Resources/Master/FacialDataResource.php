<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class FacialDataResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'face_template' => $this->face_template
    ];
  }
}
