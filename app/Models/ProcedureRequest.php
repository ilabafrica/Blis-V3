<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
* ProcedureRequest is a record of a request for a procedure to be planned, proposed, or performed
* ProcedureRequest is typically used when the requesting clinician has and wishes to exercise the authority
* (and expertise) to decide exactly what action will be done.
*/
class ProcedureRequest extends Model
{
    public function Specimen()
    {
    	return $this->belongsTo('App\Models\Specimen');
    }

    public function Coding()
    {
    	return $this->belongsTo('App\Models\Coding');
    }

    public function Status()
    {
    	return $this->belongsTo('App\Models\Status');
    }
}
