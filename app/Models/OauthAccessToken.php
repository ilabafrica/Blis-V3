<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{

    public function User()
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function OauthRefreshToken()
    {
    	return $this->hasOne('App\Models\OauthRefreshToken','access_token_id');
    }

}
