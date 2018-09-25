<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead - Emmanuel Kweyu.
 */
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = 'permission_role';

    public $timestamps = false;
    public $fillable = ['permission_id', 'role_id'];
}
