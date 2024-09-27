<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

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

    protected $keyType = 'string';
}
