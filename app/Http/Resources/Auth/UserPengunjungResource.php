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
      'nama_pengunjung' => $this->pengunjung->nama_pengunjung,
      'username' => $this->username,
      'last_login' => $this->last_login,
      'role_id' => $this->role_id,
      'role_name' => $this->role->nama_role,
      'is_suspend' => $this->is_suspend,
      'image_url' => $this->pengunjung->facialData->face_template,
    ];
  }
}
