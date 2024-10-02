<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
  protected $guarded = [];
  protected $table = 'kunjungan';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;
}
