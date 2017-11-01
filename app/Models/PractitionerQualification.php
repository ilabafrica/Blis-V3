<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PractitionerQualification extends Model
{
    public function Practitioner()
    {
        return $this->belongsTo('App\Models\Practitioner');
    }
}
