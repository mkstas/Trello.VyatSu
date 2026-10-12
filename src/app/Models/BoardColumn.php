<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardColumn extends Model
{
    protected $table = 'board_columns';

    protected $primaryKey = 'column_id';

    public $timestamps = false;

    protected $fillable = [
        'board_id',
        'ordinal_position',
        'title',
        'color',
    ];

    protected $casts = [
        'ordinal_position' => 'integer',
    ];
}
