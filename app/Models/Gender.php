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

class Gender extends Model
{

    const male = 1;
    const female = 2;
    const both = 3;
    const unknown = 4;

    public $timestamps = false;

    public function Patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function MeasureRange()
    {
        return $this->belongsTo('App\Models\MeasureRange');
    }
}
