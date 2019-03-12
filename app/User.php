<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use EntrustUserTrait;
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

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function patient()
    {
        return $this->hasOne('App\Models\Patient', 'created_by');
    }

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }

    public function telecom()
    {
        return $this->hasMany('App\Models\Telecom', 'created_by');
    }

    public function name()
    {
        return $this->hasOne('App\Models\Name', 'created_by');
    }

    public function testsDone()
    {
        return $this->hasMany('App\Models\Test', 'tested_by');
    }

    public function testsVerified()
    {
        return $this->hasMany('App\Models\Test', 'verified_by');
    }

    public function specimenCollected()
    {
        return $this->hasMany('App\Models\Specimen', 'collected_by');
    }

    public function specimenReceived()
    {
        return $this->hasMany('App\Models\Specimen', 'received_by');
    }

    public function loader()
    {
        return User::find($this->id)->load(
            'specimenReceived', 'specimenCollected'
        );
    }
}
