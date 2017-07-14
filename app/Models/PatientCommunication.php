<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientCommunication extends Model
{
    public function Patient()
    {
    	return $this->belongsTo('App\Models\Patient');
    }

}
