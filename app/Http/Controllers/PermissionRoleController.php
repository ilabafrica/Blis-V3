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
use App\Models\PermissionRole;
use Illuminate\Http\Request;

class PermissionRoleController extends Controller
{
    public function index()
    {
        $permissionsRoles = PermissionRole::all();

        return response()->json($permissionsRoles);
    }

    public function attach(Request $request)
    {
        $rules = [
            'permission_id' => 'required',
            'role_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $role = Role::find($request->input('role_id'));
            $permission = Permission::find($request->input('permission_id'));

            try {
                $role->attachPermission($permission);
                return response()->json(['message' => 'Item Successfully deleted']);

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function detach(Request $request)
    {
        $rules = [
            'permission_id' => 'required',
            'role_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return response()->json($validator);
        } else {
            $role = Role::find($request->input('role_id'));
            $permission = Permission::find($request->input('permission_id'));

            try {
                $role->detachPermission($permission);
                return response()->json(['message' => 'Item Successfully deleted']);

            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

}