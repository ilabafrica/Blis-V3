<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Direct container of specimen (tube/slide, etc.)
class Container extends Model
{
    public function Quantity()
    {
        return $this->belongsTo('App\Models\Quantity');
    }
}
