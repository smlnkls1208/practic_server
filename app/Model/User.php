<?php

namespace Model;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    public $timestamps = false;

    protected $fillable = [
        'login',
        'password',
        'role_id',
        'token',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
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

    public function findIdentityByToken(string $token)
    {
        self::ensureTokenColumn();

        return self::with('role')->where('token', $token)->first();
    }

    public function issueApiToken(): string
    {
        self::ensureTokenColumn();

        $token = bin2hex(random_bytes(32));
        $this->token = $token;
        $this->save();

        return $token;
    }

    public static function ensureTokenColumn(): void
    {
        if (Capsule::schema()->hasColumn('users', 'token')) {
            return;
        }

        Capsule::schema()->table('users', function ($table) {
            $table->string('token', 120)->nullable()->after('password');
        });
    }
}
