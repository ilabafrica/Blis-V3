<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A sample to be used for analysis.
 * https://www.hl7.org/fhir/specimen.html#Specimen.
 */
class Specimen extends Model
{
    public function test()
    {
        return $this->hasMany('App\Models\Test');
    }

    public function testTypes()
    {
        return $this->hasMany('App\Models\TestType');
    }

    public function specimenType()
    {
        return $this->belongsTo('App\Models\SpecimenType');
    }

    public function referral()
    {
        return $this->hasOne('App\Models\Referral');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\SpecimenStatus', 'specimen_status_id');
    }

    public function collectedBy()
    {
        return $this->belongsTo('App\User', 'collected_by', 'id');
    }

    public function receivedBy()
    {
        return $this->belongsTo('App\User', 'received_by', 'id');
    }
    public function rejected()
    {
        return $this->test_status_id == \App\Models\SpecimenStatus::rejected;
    }
    public function received()
    {
        return $this->specimen_status_id == \App\Models\SpecimenStatus::received;
    }
    public function pending()
    {
        return $this->specimen_status_id == \App\Models\SpecimenStatus::pending;
    }
}
