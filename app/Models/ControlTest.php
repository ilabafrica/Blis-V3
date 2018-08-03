<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class ControlTest extends Model
{
    /**
     * Relationship between control measure and its result.
     */
    public function controlResults()
    {
        return $this->hasMany('App\Models\ControlResult');
    }

    /**
     * Relationship between control test and its control.
     */
    public function controlType()
    {
        return $this->belongsTo('App\Models\ControlType');
    }

    /**
     * Relationship between control test and its lot.
     */
    public function lot()
    {
        return $this->belongsTo('App\Models\Lot');
    }

    public function testType()
    {
        return $this->belongsTo('App\Models\TestType');
    }

    public function controlTestStatus()
    {
        return $this->belongsTo('App\Models\ControlTestStatus');
    }
}
