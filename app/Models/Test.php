<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    const NOT_RECEIVED = 1;
	const PENDING = 2;
	const STARTED = 3;
	const COMPLETED = 4;
	const VERIFIED = 5;

	/**
	 * Other constants
	 */
	const POSITIVE = 'Positive';

	protected $table = 'tests';
	
}
