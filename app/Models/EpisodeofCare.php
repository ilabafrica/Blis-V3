<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
*An association between a patient and an organization / healthcare provider(s) during which time encounters may occur. 
*The managing organization assumes a level of responsibility for the patient during this time.
*The EpisodeOfCare Resource contains information about an association of a Patient with a 
*Healthcare Provider for a period of time under which related healthcare activities may occur.
*/
class EpisodeofCare extends Model
{
    public function Patient()
    {
    	return $this->belongsTo('App\Models\Patient');
    }
    public function Organization()
    {
    	return $this->belongsTo('App\Models\Organization');
    }
    public function Practitioner()
    {
    	return $this->belongsTo('App\Models\Practitioner');
    }
    public function EpisodeofCareDiagnosis()
    {
    	 return $this->hasMany('App\Models\EpisodeofCareDiagnosis','episode_of_care_id');
    }

    public function EpisodeofCareDiagnosis()
    {
         return $this->hasMany('App\Models\EpisodeofCareDiagnosis','episode_of_care_id');
    }
    
    public function ReferralRequest()
    {
         return $this->belongsTo('App\Models\ReferralRequest','based_on');
    } 

    public function StatusHistory()
    {
        return $this->hasMany('App\Models\StatusHistory','episode_of_care_id');
    }
}
