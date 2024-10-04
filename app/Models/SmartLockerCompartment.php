<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmartLockerCompartment extends Model
{
  use SoftDeletes, HasUuids;

  protected $guarded = [];
  protected $table = 'smart_locker_compartment';
  protected $keyType = 'uuid';
  public $incrementing = false;
  public $timestamps = true;
}
