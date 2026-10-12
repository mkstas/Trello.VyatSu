<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public const CREATED_AT = 'created_datetime';
    public const UPDATED_AT = 'updated_datetime';

    protected $table = 'boards';

    protected $primaryKey = 'board_id';

    protected $fillable = [
        'title',
        'owner_user_id',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}