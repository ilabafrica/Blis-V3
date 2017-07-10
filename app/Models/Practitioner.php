<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

///Patient's nominated care provider.This may be the primary care provider (in a GP context), or it may be a patient nominated care manager in a community/disablity setting, or even organization that will provide people to perform the care provider roles.

class Practitioner extends Model
{
    public function Patient()
     {
     return $this->hasMany('App\Patient','general_practitioner_id');
     	
     }

     public function PractitionerCommunications()
     {
     	return $this->hasMany('App\Models\PractitionerCommunications','practitioner_id');
     }

     public function PractitionerQualification()
     {
     	return $this->hasMany('App\Models\PractitionerQualification','practitioner_id');
     }

     public function EpisodeOfCare()
     {
          return $this->hasMany('App\Models\EpisodeOfCare','practitioners_id');
     }

     public function User()
     {
          return $this->belongsTo('App\Models\User');
     }
     public function ProcedureRequest()
     {
          return $this->hasMany('App\Models\ProcedureRequest','requester');
     }

     public function ReferralRequest()
     {
          return $this->belongsTo('App\Models\ReferralRequest','recipient');
     }
}
