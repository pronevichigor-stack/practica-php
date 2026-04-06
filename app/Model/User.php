<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'name',
        'login',
        'password',
        'id_role'
    ];

    // Связь с ролью
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    // Проверка ролей (исправлено под вашу БД)
    public function isAdmin(): bool
    {
        // В вашей БД: id_role = 2 -> admin
        return $this->id_role == 2;
    }

    public function isSysAdmin(): bool
    {
        // В вашей БД: id_role = 1 -> sysadmin
        return $this->id_role == 1;
    }

    // --- IdentityInterface ---
    public function findIdentity(int $id)
    {
        return self::where('id_user', $id)->first();
    }

    public function getId(): int
    {
        return $this->id_user;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }
}