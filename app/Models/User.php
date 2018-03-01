<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model
{
    use Notifiable;
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function patient()
    {
        return $this->hasOne('App\Models\Patient', 'created_by');
    }

    public function telecom()
    {
        return $this->hasMany('App\Models\Telecom', 'created_by');
    }

    public function name()
    {
        return $this->hasOne('App\Models\Name', 'created_by');
    }

    public function oauthAccessToken()
    {
        return $this->hasOne('App\Models\OauthAccessToken', 'created_by');
    }

    public function oauthAuthCode()
    {
        return $this->hasOne('App\Models\OauthAuthCode', 'created_by');
    }

    public function oauthClient()
    {
        return $this->hasOne('App\Models\OauthClient', 'created_by');
    }
}
