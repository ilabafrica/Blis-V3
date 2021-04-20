<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs	 - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Illuminate\Database\Eloquent\Model;

class SpecimenRejection extends Model
{
    public $timestamps = false;

    public function rejectionReason()
    {
        return $this->belongsToMany('App\Models\RejectionReason', 'reason_specimen_rejection', 'specimen_rejection_id', 'rejection_reason_id');
    }
}
