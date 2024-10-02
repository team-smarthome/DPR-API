<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengunjung extends Model
{
  use SoftDeletes, HasUuids;

  protected $guarded = [];
  protected $table = 'pengunjung';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;


  public function palmData()
  {
    return $this->hasOne(PalmData::class, 'palm_data_id', 'id');
  }

  public function facialData()
  {
    return $this->hasOne(FacialData::class, 'facial_id', 'id');
  }
}