<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//A measured amount (or an amount that can potentially be measured).
class Quantity extends Model
{
    public function Collection()
    {
    	return $this->hasMany('App\Models\Quantity');
    }

    public function Container()
    {
    	return $this->hasMany('App\Models\Container','quantity_id');
    }

    public function Observation()
    {
    	return $this->hasMany('App\Models\Observation','quantity_id');
    }
}
