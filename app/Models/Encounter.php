<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 */

use Illuminate\Database\Eloquent\Model;

class Encounter extends Model
{
    protected $fillable = ['identifier', 'encounter_class_id', 'patient_id'];

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

    public function location()
    {
        return $this->belongsTo('App\Models\Location');
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
    public static function search($searchString = '', $dateFrom = null, $dateTo = null)
    {
        $encounters = Test::with(
            'patient.name',
            'patient.gender',
            'tests.testType.specimenTypes'
        )->where(function ($q) use ($searchString) {
            $q->whereHas('patient', function ($q) use ($searchString) {
                $q->where(function ($q) use ($searchString) {
                    $q->where('identifier', '=', $searchString)
                      ->orWhere('ulin', 'like', "%{$searchString}%");
                })
                ->orWhereHas('name', function ($q) use ($searchString) {
                    $q->where('text', 'like', "%{$searchString}%");
                });
            })->where(function ($q) use ($searchString) {
                $q->where(function ($q) use ($searchString) {
                    $q->where('identifier', '=', $searchString)//Search by visit number
                    ->orWhere('id', '=', $searchString);
                });
            });
        });

        if ($dateFrom || $dateTo) {
            $encounters = $encounters->where(function ($q) use ($dateFrom, $dateTo) {
                if ($dateFrom) {
                    $q->where('created_at', '>=', $dateFrom);
                }

                if ($dateTo) {
                    $dateTo = $dateTo.' 23:59:59';
                    $q->where('created_at', '<=', $dateTo);
                }
            });
        }

        $encounters = $encounters->orderBy('created_at', 'DESC')->paginate(10);

        return $encounters;
    }
}
