<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Jabatan extends Model
{
    use SoftDeletes, HasUuids;

    protected $guarded = [];
    protected $table = 'jabatan';
    protected $keyType = 'uuid';
    public $incrementing = false;
    public $timestamps = true;

    public function Instansi(): HasOne
    {
        return $this->hasOne(Instansi::class, 'id', 'instansi_id');
    }
}
