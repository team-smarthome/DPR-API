<?php

namespace App\Http\Resources\Master;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'pegawai_id' => $this->pegawai_id,
      'is_active' => $this->pegawai->is_active,
      'username' => $this->username,
      'role_id' => $this->role_id,
      'role_name' => $this->role->nama_role,
      'is_suspend' => $this->is_suspend,
      'last_login' => $this->last_login,
    ];
  }
}
