<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    public function EpisodeOfCare()
    {
        return $this->belongsTo('App\Models\EpisodeOfCare');
    }
}
