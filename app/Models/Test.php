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

   /*
    * Search for tests meeting the given criteria
    *
    * @param String $searchString
    * @param String $testStatusId
    * @param String $dateFrom
    * @param String $dateTo
    * @return Collection
    */
    public static function search($searchString = '', $testStatusId = 0, $dateFrom = NULL, $dateTo = NULL)
    {
        $tests = Test::with(
            'encounter',
            'testStatus',
            'specimen.specimenType',
            'encounter.patient.name',
            'testType.specimenTypes',
            'encounter.patient.gender',
            'testType.measures.results',
            'results.measure.measureType',
            'testType.measures.measureType',
            'results.measure.measureRanges',
            'testType.measures.measureRanges'
        )
            ->where(function($q) use ($searchString){

            $q->whereHas('encounter', function($q) use ($searchString)
            {
                $q->whereHas('patient', function($q)  use ($searchString)
                {
                    $q->where(function($q) use ($searchString){
                        $q->where('identifier', '=', $searchString )
                          ->orWhere('ulin', 'like', "%{$searchString}%");
                    })
                    ->orWhereHas('name', function($q) use ($searchString)
                        {
                            $q->where('text', 'like', "%{$searchString}%");
                        });
                    });
            })
            ->orWhereHas('testType', function($q) use ($searchString)
            {
                $q->where('name', 'like', "%{$searchString}%");//Search by test type
            })
            ->orWhereHas('specimen', function($q) use ($searchString)
            {
                $q->where('id', '=', $searchString );//Search by specimen number
            })
            ->orWhereHas('encounter',  function($q) use ($searchString)
            {
                $q->where(function($q) use ($searchString){
                    $q->where('identifier', '=', $searchString )//Search by visit number
                    ->orWhere('id', '=', $searchString);
                });
            });
        });

        if ($testStatusId > 0) {
            $tests = $tests->where(function($q) use ($testStatusId)
            {
                $q->whereHas('testStatus', function($q) use ($testStatusId){
                    $q->where('id','=', $testStatusId);//Filter by test status
                });
            });
        }

        if ($dateFrom||$dateTo) {
            $tests = $tests->where(function($q) use ($dateFrom, $dateTo)
            {
                if($dateFrom)$q->where('created_at', '>=', $dateFrom);

                if($dateTo){
                    $dateTo = $dateTo . ' 23:59:59';
                    $q->where('created_at', '<=', $dateTo);
                }
            });
        }

        $tests = $tests->orderBy('created_at', 'DESC')->paginate(10);

        return $tests;
    }
}
