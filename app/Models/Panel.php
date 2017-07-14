<?php
/*
 
Instance of Panel

Resource link https://www.hl7.org/fhir/diagnosticreport.html
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    public function Observation()
    {
    	return $this->hasMany('App\Models\Observation','panel_id');
    }

    public function PanelType()
    {
    	return $this->belongsTo('App\Models\PanelType');
    }
    public function Specimen()
    {
    	return $this->belongsTo('App\Models\Specimen');
    }

    public function Status()
    {
        return $this->belongsTo('App\Models\Status');
    }

}

