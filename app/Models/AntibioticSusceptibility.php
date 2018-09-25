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

class AntibioticSusceptibility extends Model
{
    public $fillable = ['antibiotic_id', 'result_id', 'susceptibility_range_id'];

    public function susceptibilityRange()
    {
        return $this->belongsTo('App\Models\SusceptibilityRange');
    }

    public function result()
    {
        return $this->belongsTo('App\Models\Result');
    }

    public function antibiotic()
    {
        return $this->belongsTo('App\Models\Antibiotic');
    }
}
