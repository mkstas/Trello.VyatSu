<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public const CREATED_AT = 'created_datetime';
    public const UPDATED_AT = 'updated_datetime';

    protected $table = 'cards';

    protected $primaryKey = 'card_id';

    protected $fillable = [
        'board_id',
        'column_id',
        'sort_index',
        'title',
        'content',
        'color',
        'is_archived',
    ];

    protected $casts = [
        'sort_index'  => 'integer',
        'is_archived' => 'boolean',
    ];
}