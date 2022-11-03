<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable as AccessAuthorizable;
use Laravel\Sanctum\HasApiTokens as SanctumHasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SanctumHasApiTokens, Authenticatable, AccessAuthorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'email',
        'phone_number',
        'password',
        'name',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at'];

    public function member()
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }

    public function position()
    {
      return $this->hasOne(Position::class, 'id', 'position_id')->select('id', 'name');
    }
}
