<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    */
	protected $table = 'measures';

	/**
	 * Measure constants
	 */
	const NUMERIC = 1;
	const ALPHANUMERIC = 2;
	const AUTOCOMPLETE = 3;
	const FREETEXT = 4;

}
