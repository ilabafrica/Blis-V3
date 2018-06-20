<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use App\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    public function index()
    {
        $usersRoles = User::with('roles')->paginate(20);

        return response()->json($usersRoles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'role_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $user = User::find($request->input('user_id'));
            $role = Role::find($request->input('role_id'));

            try {
                $user->attachRole($role);
                $user = User::with('roles')->find($request->input('user_id'));

                return response()->json($user);
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
        $rules = [
            'user_id' => 'required',
            'role_id' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator);
        } else {
            $role = Role::find($request->input('role_id'));
            $user = User::find($request->input('user_id'));

            try {
                $user->detachRole($role);
                $user = User::with('roles')->find($request->input('user_id'));

                return response()->json($user);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }
}
