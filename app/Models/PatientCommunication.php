<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientCommunications extends Model
{
    public function Patient()
    {
    	return $this->belongsTo('App\Models\Patient');
    }

}
