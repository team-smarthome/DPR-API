<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Device extends Model
{
    use SoftDeletes, HasUuids;

    protected $guarded = [];
    protected $table = 'device';
    protected $keyType = 'uuid';
    public $incrementing = false;
    public $timestamps = true;
}
