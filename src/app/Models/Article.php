<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Article extends Authenticatable
{
    use HasFactory, Notifiable;

    public int $user_id;
    public string $title;
    public string $body;
    public string $posted_at;
    public string $updated_at;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'posts';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'posted_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'posted_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
