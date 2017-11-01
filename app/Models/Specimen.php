<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A sample to be used for analysis.
 * https://www.hl7.org/fhir/specimen.html#Specimen.
 */
class Specimen extends Model
{
    /**
     * Specimen status constants.
     */
    const NOT_COLLECTED = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;

    public function Panel()
    {
        return $this->hasMany('App\Models\Panel', 'specimen_id');
    }

    public function ProcedureRequest()
    {
        return $this->hasMany('App\Models\ProcedureRequest', 'specimen');
    }
}
