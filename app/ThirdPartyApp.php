<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ThirdPartyApp extends Authenticatable implements JWTSubject
{
    use EntrustUserTrait;
    use Notifiable;

    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function emr()
    {
        return $this->hasOne('\ILabAfrica\EMRInterface\EMR', 'third_party_app_id');
    }

    public function access()
    {
        return $this->hasOne('\App\Models\ThirdPartyAccess', 'third_party_app_id');
    }

    public function loader()
    {
        return ThirdPartyApp::find($this->id)->load(
            'emr', 'access'
        );
    }
}
