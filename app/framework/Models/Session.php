<?php declare(strict_types=1);

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    protected $table      = 'sessions';
    protected $primaryKey = 'session_id';
    protected $keyType    = 'string';
    public $incrementing  = false;
    public $timestamps    = false;

    protected $fillable = [
        'session_id',
        'user_id',
        'ip_address',
        'created_at',
        'expires_at',
        'last_seen_at',
    ];

    protected $casts = [
        'created_at'   => 'datetime',
        'expires_at'   => 'datetime',
        'last_seen_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
