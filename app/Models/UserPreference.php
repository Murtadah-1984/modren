<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class UserPreference extends Model
{
    protected $fillable = ['user_id', 'theme', 'layout', 'language', 'widgets'];

    protected $casts = ['widgets' => 'array'];
}
