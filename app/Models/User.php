<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    const ROLE_ADMIN = 'admin';
    const ROLE_WRITER = 'writer';
    const ROLE_USER = 'user';

    const WRITER_STATUS_NONE = 'none';
    const WRITER_STATUS_PENDING = 'pending';
    const WRITER_STATUS_APPROVED = 'approved';
    const WRITER_STATUS_REJECTED = 'rejected';

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isWriter()
    {
        return $this->role === self::ROLE_WRITER;
    }

    public function canPost()
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_WRITER]);
    }

    public function hasPendingWriterRequest()
    {
        return $this->writer_status === self::WRITER_STATUS_PENDING;
    }

    public function canRequestWriter()
    {
        return $this->role === self::ROLE_USER && in_array($this->writer_status, [self::WRITER_STATUS_NONE, self::WRITER_STATUS_REJECTED]);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'writer_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
