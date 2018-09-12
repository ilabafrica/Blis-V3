<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs	 - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function tests()
    {
        return $this->hasMany('App\Models\Test');
    }

    public function specimens()
    {
        return $this->hasMany('App\Models\Specimen');
    }

    public function loader()
    {
        return Encounter::find($this->id)->load(
            'patient.name',
            'patient.gender',
            'tests.testType.specimenTypes'
        );
    }

   /*
    * Search for tests meeting the given criteria
    *
    * @param String $searchString
    * @param String $dateFrom
    * @param String $dateTo
    * @return Collection
    */
    public static function search($searchString = '', $dateFrom = NULL, $dateTo = NULL)
    {
        $encounters = Test::with(
            'patient.name',
            'patient.gender',
            'tests.testType.specimenTypes'
        )->where(function($q) use ($searchString){

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
            })->where(function($q) use ($searchString)
            {
                $q->where(function($q) use ($searchString){
                    $q->where('identifier', '=', $searchString )//Search by visit number
                    ->orWhere('id', '=', $searchString);
                });
            });
        });

        if ($dateFrom||$dateTo) {
            $encounters = $encounters->where(function($q) use ($dateFrom, $dateTo)
            {
                if($dateFrom)$q->where('created_at', '>=', $dateFrom);

                if($dateTo){
                    $dateTo = $dateTo . ' 23:59:59';
                    $q->where('created_at', '<=', $dateTo);
                }
            });
        }

        $encounters = $encounters->orderBy('created_at', 'DESC')->paginate(10);

        return $encounters;
    }
}
