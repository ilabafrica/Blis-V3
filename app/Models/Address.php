<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

 //Patient may have multiple addresses with different uses or applicable periods.

class Address extends Model
{
public function Patient()
    {
   	
    	 return $this->belongsTo('App\Model\Patient');
    }
}