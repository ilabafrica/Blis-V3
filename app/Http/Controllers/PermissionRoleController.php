<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function index()
    {
        $rolesPermissions = Role::with('perms')->paginate(20);
        return response()->json($rolesPermissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'permission_id' => 'required',
            'role_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $role = Role::find($request->input('role_id'));
            $permission = Permission::find($request->input('permission_id'));

            try {
                $role->attachPermission($permission);
                $role = Role::with('perms')->find($request->input('role_id'));
                return response()->json($role);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $rules = array(
            'permission_id' => 'required',
            'role_id' => 'required',
        );

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $role = Role::find($request->input('role_id'));
            $permission = Permission::find($request->input('permission_id'));

            try {
                $role->detachPermission($permission);
                $role = Role::with('perms')->find($request->input('role_id'));
                return response()->json($role);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}