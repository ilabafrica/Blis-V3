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

class SpecimenType extends Model
{
    public function specimenTypeTestType()
    {
        return $this->hasMany('App\Models\specimenTypeTestType');
    }

    public function testType()
    {
        return $this->belongsToMany('App\Models\TestType');
    }	
}
