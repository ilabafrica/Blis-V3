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

class Antibiotic extends Model
{
    public $timestamps = false;

    public function measureRanges()
    {
        return $this->belongsToMany('App\Models\MeasureRange','susceptibility_break_points', 'antibiotic_id','measure_range_id');
    }
}
