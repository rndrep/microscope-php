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

    public function isAdmin()
    {
        return $this->role_id == self::ROLE_ADMIN;
    }

    public function isUser()
    {
        return $this->role_id == self::ROLE_USER;
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->patronymic;
    }

    public function getRoleName()
    {
        return self::ROLE_NAMES[$this->role_id];
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setPassword($password)
    {
        if (!empty($password)) {
            $this->password = Hash::make($password);
//            $this->save();
        }
    }

    public function setRoleId($roleId)
    {
        if (in_array($roleId, array_keys(self::ROLE_NAMES))) {
            $this->role_id = $roleId;
//            $this->save();
        }
    }

}
