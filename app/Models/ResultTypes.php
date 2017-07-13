<?php

/*
* he information determined as a result of making the observation, if the information has a simple value.
*
* https://www.hl7.org/fhir/observation-definitions.html#Observation.component.value_x_
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultTypes extends Model
{
    public function ComponentType()
    {
    	return $this->hasMany('App\Models\ComponentType','result_type_id');
    }
}
