<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 */

use Illuminate\Database\Eloquent\Model;

class ControlTestStatus extends Model
{
	const pending = 1;
	const completed = 2;
    public $timestamps = false;
}
