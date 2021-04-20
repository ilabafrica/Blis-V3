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
use App\Models\MeasureRange;
use App\Models\Patient;

class Result extends Model
{
    protected $fillable = ['test_id', 'measure_id', 'measure_range_id', 'result', 'time_entered'];

    public $timestamps = false;

    public function test()
    {
        return $this->belongsTo('App\Models\Test');
    }

    public function measure()
    {
        return $this->belongsTo('App\Models\Measure');
    }

    public function measureRange()
    {
        return $this->belongsTo('App\Models\MeasureRange');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\ResultLog');
    }

    public static function getRange($patient,$measureId)
    {
        $age = $patient->getAge('ref_range_Y');
        // if for particular gender is zero, check for both genders
        $rangeValidity = MeasureRange::where('measure_id', '=', $measureId)
            ->where('age_min', '<=', $age)->where('age_max', '>=', $age)
            ->where('gender_id', '=', $patient->gender);
        $measureRange = new \stdClass();

        if ($rangeValidity->count()==0) {
            $measureRange = MeasureRange::where('measure_id', '=', $measureId)
                ->where('age_min', '<=', $age)->where('age_max', '>=', $age)
                ->where('gender_id', '=', Gender::both)->first();
            if (is_null($measureRange)) {
                // age is outside the provided reference ranges
                return null;
            }
        }else{
            $measureRange = $rangeValidity->first();
        }
        return "(".substr($measureRange->range_lower, 0, -2)." - ".substr($measureRange->range_upper, 0, -2).")";
    }
}
