<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs	 - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * Function for getting the admin role, currently the first user.
     */
    public static function getAdminRole()
    {
        return Role::find(1);
    }

    public function permissionRole()
    {
        return $this->hasMany('App\Models\PermissionRole');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }
}
