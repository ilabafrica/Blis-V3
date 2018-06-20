<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class ControlMeasureRange extends Model
{
    public function controlMeasure()
    {
        return $this->belongsTo('controlMeasure');
    }

    /**
     * Get ranges in printable format.
     *
     * @return string
     */
    public function getRangeUnit()
    {
        $lower = $this->lower_range;
        $upper = $this->upper_range;
        $unit = $this->unit;

        return $lower.' - '.$upper.' '.$this->ControlMeasure->unit;
    }
}
