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

class MeasureRange extends Model
{
    public $timestamps = false;

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }

    public function measure()
    {
        return $this->belongsTo('App\Models\Measure');
    }

    public function interpretation()
    {
        return $this->belongsTo('App\Models\Interpretation');
    }

    public function susceptibilityBreakPoints()
    {
        return $this->hasMany('App\Models\SusceptibilityBreakPoint');
    }

    public function antibiotics()
    {
        return $this->belongsToMany('App\Models\Antibiotic', 'susceptibility_break_points', 'measure_range_id', 'antibiotic_id');
    }

    public function loader()
    {
        return MeasureRange::find($this->id)->load(
            'gender', 'interpretation', 'susceptibilityBreakPoints'
        );
    }
}
