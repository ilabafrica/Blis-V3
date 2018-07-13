<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead - Emmanuel Kweyu.
 */
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public $timestamps = false;
    public $fillable = ['user_id', 'role_id'];
}
