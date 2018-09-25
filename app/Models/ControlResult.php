<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class ControlResult extends Model
{
    protected $fillable = ['control_test_id', 'measure_id', 'measure_range_id'];

    /**
     * Relationship between result and measure.
     *
     * @return relationship
     */
    public function measure()
    {
        return $this->belongsTo('App\Models\Measure');
    }

    /**
     * Relationship between result and test.
     *
     * @return relationship
     */
    public function controlTest()
    {
        return $this->belongsTo('App\Models\ControlTest');
    }
}
