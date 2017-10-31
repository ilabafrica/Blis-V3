<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EpisodeOfCareDiagnosis extends Model
{
    public function EpisodeOfCare()
    {
        return $this->belongsTo('App\Models\EpisodeOfCare');
    }
}
