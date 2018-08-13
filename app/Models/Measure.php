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

class Measure extends Model
{
    public function testType()
    {
        return $this->belongsTo('App\Models\TestType');
    }

    public function measureType()
    {
        return $this->belongsTo('App\Models\MeasureType');
    }

    public function measureRanges()
    {
        return $this->hasMany('App\Models\MeasureRange');
    }

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    public function controlResults()
    {
        return $this->hasMany('App\Models\ControlResult');
    }
}
