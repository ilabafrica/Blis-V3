<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
	Demographics and other administrative information about an individual or animal receiving care or 
	other health-related services.racking patient is the center of the healthcare process.
	https://www.hl7.org/fhir/patient.html
*/

class Patient extends Model
{
	protected $table = 'patients';
    
    const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;
	const UNKNOWN = 3;

}
