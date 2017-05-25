<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specimen extends Model
{
   /**
	 * Specimen status constants
	 */
	const NOT_COLLECTED = 1;
	const ACCEPTED = 2;
	const REJECTED = 3;
}
