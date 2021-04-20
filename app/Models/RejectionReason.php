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

class RejectionReason extends Model
{
    public $timestamps = false;

    public function specimenRejection()
    {
        return $this->belongsToMany('App\Models\SpecimenRejection', 'reason_specimen_rejection', 'rejection_reason_id', 'specimen_rejection_id');
    }

    public function loader()
    {
        return RejectionReason::find($this->id)->load(
            'specimenRejection'
        );
    }
}
