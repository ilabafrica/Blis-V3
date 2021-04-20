<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//A patient may have multiple names with different uses or applicable periods. For animals, the name is a "Name" in the sense that is assigned and used by humans and has the same patterns.

class Name extends Model
{
    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function Patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }
}
