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
}
