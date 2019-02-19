<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultLog extends Model
{
    protected $guarded = ['id'];

    public function result()
    {
        return $this->belongsTo('App\Models\Result');
    }
}
