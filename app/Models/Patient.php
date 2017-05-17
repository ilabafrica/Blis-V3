<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
	protected $table = 'patients';
    
    const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;
	const UNKNOWN = 3;
}
