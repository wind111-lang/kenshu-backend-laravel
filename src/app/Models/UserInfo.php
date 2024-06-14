<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserInfo extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'userinfo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'username',
        'password',
        'user_image',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @property string $password
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
