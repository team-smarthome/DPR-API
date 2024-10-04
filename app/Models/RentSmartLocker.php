<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentSmartLocker extends Model
{
  use SoftDeletes, HasUuids;

  protected $guarded = [];
  protected $table = 'rent_smart_locker';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;
}
