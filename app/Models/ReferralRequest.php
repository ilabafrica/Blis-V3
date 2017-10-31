<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Used to record and send details about a request for referral service or transfer
//of a patient to the care of another provider or provider organization.

class ReferralRequest extends Model
{
    public function Status()
    {
        return $this->belongsTo('App\Models\Status');
    }
}
