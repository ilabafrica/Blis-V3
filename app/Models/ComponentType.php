<?php

/*
Sometimes called measures/methods

Some observations have multiple component observations. These component observations are expressed as separate code value pairs that share the same attributes. Examples include systolic and diastolic component observations for blood pressure measurement and multiple component observations for genetics observations.

https://www.hl7.org/fhir/observation-definitions.html#Observation.component
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    //
}
