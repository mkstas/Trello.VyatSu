<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public const CREATED_AT = 'created_datetime';
    public const UPDATED_AT = 'updated_datetime';

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'email',
        'password_hash',
        'name',
    ];

    protected $hidden = [
        'password_hash',
    ];
}
