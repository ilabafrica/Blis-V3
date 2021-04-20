<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Identifier for the organization that is used to identify the organization across multiple disparate systems.Organizations are known by a variety of ids. Some institutions maintain several, and most collect identifiers for exchange with other organizations concerning the organization.

class Organization extends Model
{
    public function Patient()
    {
        return $this->hasOne('App\Models\Patient');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
