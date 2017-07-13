<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function Patient()
     {
        return $this->hasOne('App\Models\Patient', 'user_id');
     }
     
    public function ContactPoint()
     {
        return $this->hasMany('App\Models\ContactPoint','user_id');
     }
    public function HumanName()
    {
    	return $this->hasOne('App\Models\HumanName','user_id');
    }

    public function OauthAccessToken()
    {
    	return $this->hasOne('App\Models\OauthAccessToken','user_id');
    }

    public function OauthAuthCode()
    {
    	return $this->hasOne('App\Models\OauthAuthCode','user_id');
    }
    public function OauthClient()
    {
    	return $this->hasOne('App\Models\OauthClient','user_id');
    }

    public function Observation()
    {
        return $this->hasOne('App\Models\Observation','user_id');
    }

    public function Organization()
    {
        return $this->hasOne('App\Models\Organization','user_id');
    }

    public function Practitioner()
    {
        return $this->hasOne('App\Models\Practitioner','user_id');
    }

    public function ProcedureRequest()
    {
        return $this->hasOne('App\Models\ProcedureRequest','performer');
    }
}
