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

class TestStatus extends Model
{
    const pending = 1;
    const started = 2;
    const completed = 3;
    const verified = 4;
    const cancelled = 5;
    public $timestamps = false;

    public function testPhase()
    {
        return $this->belongsTo('App\Models\TestPhase');
    }
}
