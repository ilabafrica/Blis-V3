<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
*The Care Team resource includes all the people and/or organizations who plan to participate in the coordination 
*and delivery of care for a patient. This is not limited to practitioners, 
*but may include other caregivers such as family members, guardians, the patient themself, or others. 
*The Care Team, depending on where used, may include care team members specific to a particular care plan, 
*an episode, an encounter, or may reflect all known team members across these perspectives.
*/
class CareTeam extends Model
{
    public function Status()
    {
    	return $this->hasOne('App\Models\Status');	
    }

    public function Organization()
    {
    	return $this->belongsTo('App\Models\Organization');
    }
}
