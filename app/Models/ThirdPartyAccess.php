<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThirdPartyAccess extends Model
{
    protected $table = 'third_party_access';

    protected $fillable = [
        'third_party_app_id', 'username', 'email', 'password', 'grant_type', 'client_name', 'client_id', 'client_secret', 'access_token', 'remember_token'
    ];
}
