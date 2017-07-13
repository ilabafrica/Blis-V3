<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PractitionerQualifications extends Model
{
    public function Practitioner()
    {
    	return $this->belongsTo('App\Models\Practitioner');
    }
}
