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
}
