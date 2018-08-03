<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    public function instrument()
    {
        return $this->belongsTo('App\Models\Instrument');
    }

    public function controlTest()
    {
        return $this->belongsTo('App\Models\ControlTest');
    }
}
