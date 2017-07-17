<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
* Details concerning the specimen collection.
*/
class Collection extends Model
{
    public function Quantity()
    {
    	return $this->belongsTo('App\Models\Quantity');
    }
}
