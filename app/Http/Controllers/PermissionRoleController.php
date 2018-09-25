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
use App\Models\PermissionRole;

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
            return response()->json($validator, 422);
        } else {
            try {
                $permissionRole = PermissionRole::create([
                    'permission_id' => $request->input('permission_id'),
                    'role_id' => $request->input('role_id'),
                ]);

                return response()->json($permissionRole);
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
            return response()->json($validator, 422);
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
