<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPengunjungResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'pegunjung_id' => $this->pengunjung_id,
      'username' => $this->username,
      'last_login' => $this->last_login,
      'image_url' => $this->pengunjung->facialData->face_template,
    ];
  }
}
