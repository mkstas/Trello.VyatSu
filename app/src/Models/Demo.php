<?php

declare(strict_types=1);

namespace App\Models;

class Demo extends Model
{
    protected $table = 'demos';

    protected $fillable = [
        'note',
    ];
}
