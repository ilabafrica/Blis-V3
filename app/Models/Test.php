<?php
/*

Instance of Test

Resource link https://www.hl7.org/fhir/diagnosticreport.html
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function testType()
    {
        return $this->belongsTo('App\Models\TestType');
    }

    public function specimen()
    {
        return $this->belongsTo('App\Models\Specimen');
    }

    /*
     * User (created) relationship
     */
    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    /*
     * User (tested) relationship
     */
    public function testedBy()
    {
        return $this->belongsTo('App\User', 'tested_by', 'id');
    }

    /*
     * User (verified) relationship
     */
    public function verifiedBy()
    {
        return $this->belongsTo('App\User', 'verified_by', 'id');
    }

    /*
     * Test Results relationship
     */
    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    /*
     * Test Status relationship
     */
    public function testStatus()
    {
        return $this->belongsTo('App\Models\TestStatus');
    }

    public function encounter()
    {
        return $this->belongsTo('App\Models\Encounter');
    }
}
