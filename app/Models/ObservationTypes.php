<?php

/*
Sometimes called tests. 
Observations are a central element in healthcare, used to support diagnosis, monitor progress, determine baselines and patterns and even capture demographic characteristics. Most observations are simple name/value pair assertions with some metadata, but some observations group other observations together logically, or even are multi-component observations. Note that the DiagnosticReport resource provides a clinical or workflow context for a set of observations and the Observation resource is referenced by DiagnosticReport to represent lab, imaging, and other clinical and diagnostic data to form a complete report.

Source https://www.hl7.org/fhir/observation.html
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObservationTypes extends Model
{
    public function Status()
    {
    	return $this->belongsTo('App\Models\Status');
    }

    public function Coding()
    {
    	return $this->belongsTo('App\Models\Coding');
    }
}
