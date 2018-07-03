<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A sample to be used for analysis.
 * https://www.hl7.org/fhir/specimen.html#Specimen.
 */
class Specimen extends Model
{
    public $timestamps = false;

    public function test()
    {
        return $this->hasMany('App\Models\Test');
    }

    public function testTypes()
    {
        return $this->hasMany('App\Models\TestType');
    }
}
