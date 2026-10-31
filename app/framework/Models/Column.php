<?php declare(strict_types=1);

namespace Framework\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $table = 'columns';

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
