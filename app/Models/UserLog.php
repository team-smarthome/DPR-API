<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLog extends Model
{
    protected $table = 'user_log';

    protected $fillable = [
        'id',
        'user_id',
        'nama_user_log',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $incrementing = false;
    protected $keyType = 'uuid';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
