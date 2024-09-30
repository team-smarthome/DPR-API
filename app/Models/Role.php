<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends Model
{
    use SoftDeletes, HasUuids;

    protected $guarded = [];
    protected $table = 'role';
    protected $keyType = 'uuid';
    public $incrementing = false;
    public $timestamps = true;

    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
