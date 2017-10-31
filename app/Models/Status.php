<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Past list of status codes (the current status may be included to cover the start date of the status)
class Status extends Model
{
    public function Care_teams($value = '')
    {
        return $this->belongsTo('App\Models\CareTeam', 'status_id');
    }

    public function Observation()
    {
        return $this->hasMany('App\Models\Observation', 'status_id');
    }

    public function ObservationType()
    {
        return $this->hasMany('App\Models\ObservationType', 'status_id');
    }

    public function Panel()
    {
        return $this->hasMany('App\Models\Panel', 'status_id');
    }

    public function PanelType()
    {
        return $this->hasMany('App\Models\PanelType', 'status_id');
    }

    public function ProcedureRequest()
    {
        return $this->hasMany('App\Models\ProcedureRequest', 'status');
    }

    public function ReferralRequest()
    {
        return $this->hasMany('App\Models\ReferralRequest', 'status');
    }

    public function Substance()
    {
        return $this->hasOne('App\Models\Substance', 'status');
    }
}
