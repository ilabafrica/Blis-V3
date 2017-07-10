<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coding extends Model
{
    public function ComponentTypes()
    {
    	return $this->hasMany('App\Models\ComponentTypes','code_id');
    }

    public function ObservationTypes()
    {
    	return $this->hasMany('App\Models\ObservationTypes','code_id');
    }

    public function PanelType()
    {
    	return $this->hasMany('App\Models\PanelType','code_id');
    }

    public function ProcedureRequest()
    {
        return $this->hasOne('App\Models\ProcedureRequest','code');
    }

    public function Substance()
    {
        return $this->hasOne('App\Models\Substance','code');
    }
}
