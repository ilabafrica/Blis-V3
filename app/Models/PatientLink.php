<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PatientLink extends Model
{
    public function Patient()
    {
    	return $this->belongsTo('App\Models\Patient','patient_id');
    }

}
