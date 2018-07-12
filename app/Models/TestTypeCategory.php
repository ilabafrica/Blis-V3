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

class TestTypeCategory extends Model
{

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function testTypes()
    {
        return $this->hasMany('App\Models\TestType');
    }
}
