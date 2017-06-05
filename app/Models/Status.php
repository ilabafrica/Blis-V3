<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// Past list of status codes (the current status may be included to cover the start date of the status)
class Status extends Model
{
    public function Care_teams($value='')
     {
     	return $this->belongsTo('App\Models\CareTeam','status_id');
     }
}
