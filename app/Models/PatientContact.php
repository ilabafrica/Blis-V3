<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Contact covers all kinds of contact parties: family members, business contacts, guardians, caregivers. Not applicable to register pedigree and family ties beyond use of having contact.

class PatientContact extends Model
{
    public function Patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function Organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
