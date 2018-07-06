<?php
/*

A diagnostic report or panel(TestType in BLIS) is the set of information that is typically provided by a diagnostic service when investigations are complete. The words "tests", "results", "observations", "panels" and "batteries" are often used interchangeably when describing the various parts of a diagnostic report. The information includes a mix of atomic results, text reports, images, and codes. The mix varies depending on the nature of the diagnostic procedure, and sometimes on the nature of the outcomes for a particular investigation. In FHIR, the report can be conveyed in a variety of ways including a Document, RESTful API, or Messaging framework. Included within each of these, would be the DiagnosticReport resource itself.

Resource link https://www.hl7.org/fhir/diagnosticreport.html
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function test()
    {
        return $this->hasMany('App\Models\Test');
    }

    public function specimenTypes()
    {
        return $this->belongsToMany('App\Models\SpecimenType','test_type_mappings');
    }

    public function measures()
    {
        return $this->hasMany('App\Models\Measure');
    }
}
