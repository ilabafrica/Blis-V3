<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coding extends Model
{
    public function ComponentType()
    {
    	return $this->hasMany('App\Models\ComponentTypes','code_id');
    }

    public function ObservationType()
    {
    	return $this->hasMany('App\Models\ObservationType','code_id');
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
