<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPengunjung extends Model
{
  use SoftDeletes, HasFactory, HasUuids;

  // Nama tabel yang terkait dengan model ini
  protected $guarded = [];
  protected $table = 'user_pengunjung';
  public $incrementing = false;
  protected $keyType = 'uuid';
  public $timestamps = true;




  // Relasi ke model Pengunjung
  public function pengunjung()
  {
    return $this->belongsTo(Pengunjung::class, 'pengunjung_id', 'id');
  }

  // Relasi ke model Role
  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }
}
