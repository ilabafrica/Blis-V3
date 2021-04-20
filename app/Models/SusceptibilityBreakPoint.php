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

class SusceptibilityBreakPoint extends Model
{
    public $timestamps = false;

    const SENSITIVE = 1;
    const INTERMEDIATE = 2;
    const RESISTANT = 3;

    public function antibiotic()
    {
        return $this->belongsTo('App\Models\Antibiotic');
    }

    public function measureRange()
    {
        return $this->belongsTo('App\Models\MeasureRange');
    }

    public function getSusceptibilityRange($diameter)
    {
        if ($diameter <= $this->resistant_max) {
            return SusceptibilityRange::find(SusceptibilityBreakPoint::RESISTANT)->id;
        } elseif ($diameter >= $this->sensitive_min) {
            return SusceptibilityRange::find(SusceptibilityBreakPoint::SENSITIVE)->id;
        } elseif ($diameter >= $this->intermediate_min) {
            return SusceptibilityRange::find(SusceptibilityBreakPoint::INTERMEDIATE)->id;
        } elseif ($diameter <= $this->intermediate_max) {
            return SusceptibilityRange::find(SusceptibilityBreakPoint::INTERMEDIATE)->id;
        } else {
            /*todo: if the caller gets this reply tell the user the diameter is not valid,
            so they can insist problematic range, what do we do?
            ask user to configure, send message to the front
            return null;
            with a link to the place where to make changes, if you have rights
            */
        }
    }

    public function loader()
    {
        return SusceptibilityBreakPoint::find($this->id)->load(
            'antibiotic'
        );
    }
}
