<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'pegawai_id',
        'username',
        'password',
        'role_id',
        'is_suspend',
        'last_login',
    ];

    public $incrementing = false;
    public $timestamps = true;
    protected $keyType = 'uuid';

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function userLogin()
    {
        return $this->hasMany(UserLogin::class, 'user_id', 'id');
    }

    public function userLog()
    {
        return $this->hasMany(UserLog::class, 'user_id', 'id');
    }
}
