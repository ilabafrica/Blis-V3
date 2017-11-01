<?php

/*
Instance of observation

Source https://www.hl7.org/fhir/observation.html
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    public function Component()
    {
        return $this->hasMany('App\Models\Component', 'observation_id');
    }

    public function Status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function Panel()
    {
        return $this->belongsTo('App\Models\Panel');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function Quantity()
    {
        return $this->belongsTo('App\Models\Quantity');
    }
}
