<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function Patient()
    {
        return $this->hasOne('App\Models\Patient', 'created_by');
    }

    public function ContactPoint()
    {
        return $this->hasMany('App\Models\ContactPoint', 'created_by');
    }

    public function HumanName()
    {
        return $this->hasOne('App\Models\HumanName', 'created_by');
    }

    public function OauthAccessToken()
    {
        return $this->hasOne('App\Models\OauthAccessToken', 'created_by');
    }

    public function OauthAuthCode()
    {
        return $this->hasOne('App\Models\OauthAuthCode', 'created_by');
    }

    public function OauthClient()
    {
        return $this->hasOne('App\Models\OauthClient', 'created_by');
    }

    public function Observation()
    {
        return $this->hasOne('App\Models\Observation', 'created_by');
    }

    public function Organization()
    {
        return $this->hasOne('App\Models\Organization', 'created_by');
    }

    public function Practitioner()
    {
        return $this->hasOne('App\Models\Practitioner', 'created_by');
    }

    public function ProcedureRequest()
    {
        return $this->hasOne('App\Models\ProcedureRequest', 'performer');
    }
}
