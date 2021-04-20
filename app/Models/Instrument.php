<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    public function lot()
    {
        return $this->belongsTo('App\Models\Lot');
    }

    public function testTypes()
    {
        return $this->belongsToMany('App\Models\TestType');
    }

    public function instrumentMapping()
    {
        return $this->hasMany('ILabAfrica\EquipmentInterface\InstrumentMapping');
    }

    public function loader()
    {
        return Instrument::find($this->id)->load(
            'instrumentMapping'
        );
    }
}
