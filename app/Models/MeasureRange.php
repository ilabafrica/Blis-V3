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

    public function susceptibilityBreakPoints()
    {
        return $this->hasMany('App\Models\SusceptibilityBreakPoint');
    }
}
