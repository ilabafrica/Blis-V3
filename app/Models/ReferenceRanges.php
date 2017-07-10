<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceRange extends Model
{
    //Days, months, Years on age min/age max


    public function ComponentTypes()
    {
    	return $this->hasMany('App\Models\ComponentTypes','reference_range_id');
    }
}
