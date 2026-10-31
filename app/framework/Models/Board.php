<?php declare(strict_types=1);

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $table = 'boards';

    protected $primaryKey = 'board_id';

    protected $fillable = [
        'user_id',
        'title',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];
}
