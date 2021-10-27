<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    const ROLE_NAMES = [
        1 => 'Администратор',
        2 => 'Студент'
    ];

//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
//    protected $fillable = [
//        'name',
//        'login',
//        'password',
//        'email',
//        'auth',
//        'first_name',
//        'last_name',
//        'patronymic',
//        'role_id',
//        'created_at',
//        'modified_at',
//    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['password', 'role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
//        'email_verified_at' => 'datetime',
        'email_verified_at' => 'timestamp',
    ];

    public static function add($fields)
    {
        $item = new static;
        $item->fill($fields);
        $item->save();
        return $item;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function isAdmin(): bool
    {
        return $this->role_id == self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role_id == self::ROLE_USER;
    }

    public function isSSO()
    {
        return $this->is_sso;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    public function getFullName(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->patronymic;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->role_id;
    }

    public function getRoleName(): string
    {
        return self::ROLE_NAMES[$this->role_id];
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setSSO($value): self
    {
        $this->is_sso = (int) $value;
        return $this;
    }

    public function setLogin($value): self
    {
        $this->login = $value;
        return $this;
    }

    public function setEmail($value): self
    {
        $this->email = $value;
        return $this;
    }

    public function setFirstName($value): self
    {
        $this->first_name = $value;
        return $this;
    }

    public function setLastName($value): self
    {
        $this->last_name = $value;
        return $this;
    }

    public function setPatronymic($value): self
    {
        $this->patronymic = $value;
        return $this;
    }

    public function setPassword($password): self
    {
        if (!empty($password)) {
            $this->password = Hash::make($password);
        }
        return $this;
    }

    public function setRoleId($roleId): self
    {
        if (in_array($roleId, array_keys(self::ROLE_NAMES))) {
            $this->role_id = $roleId;
        }
        return $this;
    }

}
