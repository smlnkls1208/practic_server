<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'role_id',
    ];

    protected static function booted(): void
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function findIdentity(int $id)
    {
        return self::with('role')->where('id', $id)->first();
    }

    public function getId(): int
    {
        return (int)$this->id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::with('role')->where([
            'login' => $credentials['login'] ?? '',
            'password' => md5($credentials['password'] ?? ''),
        ])->first();
    }
}