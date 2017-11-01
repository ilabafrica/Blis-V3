<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
    Demographics and other administrative information about an individual or animal receiving care or
    other health-related services.racking patient is the center of the healthcare process.
    https://www.hl7.org/fhir/patient.html
*/

class Patient extends Model
{
    protected $table = 'patients';

    const MALE = 0;
    const FEMALE = 1;
    const BOTH = 2;
    const UNKNOWN = 3;

    public function Address()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function Coding()
    {
        return $this->hasOne('App\Models\Coding', 'patient_id');
    }

    public function ContactPoint()
    {
        return $this->hasMany('App\Models\ContactPoint', 'patient_id');
    }

    public function CodeableConceptMaritalStatus()
    {
        return $this->hasOne('App\Models\CodeableConcept', 'code');
    }

    public function CodeableConceptAnimalSpecies()
    {
        return $this->belongsToOne('App\Models\CodeableConcept', 'code');
    }

    public function EpisodesOfCare()
    {
        return $this->hasMany('App\Models\EpisodesOfCare', 'patient_id');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function HumanName()
    {
        return $this->hasOne('App\Models\HumanName', 'patient_id');
    }

    public function Practitioner()
    {
        return $this->hasOne('App\Models\Practitioner');
    }

    public function PractitionerCommunication()
    {
        return $this->hasMany('App\Models\PractitionerCommunication', 'patient_id');
    }

    public function PatientCommunication()
    {
        return $this->hasMany('App\Models\PatientCommunication', 'patient_id');
    }

    public function PatientContact()
    {
        return $this->hasMany('App\Models\PatientContact', 'patient_id');
    }

    public function PatientLink()
    {
        return $this->hasMany('App\Models\PatientLink');
    }

    public function ReferralRequest()
    {
        return $this->belongsTo('App\Models\ReferralRequest', 'subject');
    }

    public function Organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
