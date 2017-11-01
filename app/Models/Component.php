<?php

//Instance of components

//https://www.hl7.org/fhir/observation-definitions.html#Observation.component

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function Observation()
    {
        return $this->belongsTo('App\Models\Observation');
    }
}
