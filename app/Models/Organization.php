<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


//Identifier for the organization that is used to identify the organization across multiple disparate systems.Organizations are known by a variety of ids. Some institutions maintain several, and most collect identifiers for exchange with other organizations concerning the organization.

class Organization extends Model
{
    public function CareTeams()
    {
    	return $this->hasOne('App\Models\CareTeam','Organization_id');
    }

    public function OrganizationContact()
    {
    	return $this->hasMany('App\Models\OrganizationContact','organization_id');
    }
    public function Patient()
    {
        return $this->hasOne('App\Models\Patient','managing_organization');
    }
    public function PatientContact()
    {
    	return $this->hasMany('App\Models\PatientContact','organization_id');
    }
    public function EpisodeOfCare()
    {
        return $this->hasMany('App\Models\EpisodeOfCare','organization_id');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
