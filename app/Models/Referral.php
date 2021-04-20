<?php
/*
 * Used to record and send details about a request for referral service or transfer
 * of a patient to the care of another provider or provider organization.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    public function referralReason()
    {
        return $this->belongsToMany('App\Models\ReferralReason', 'reason_referral');
    }
}
