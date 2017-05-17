<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return response()->json($roles);
        
    }

    public function assign()
    {
        $users = User::all();
        $roles = Role::all();
        $userRoleData = array('users'=>$users, 'roles'=>$roles);

        return response()->json($userRoleData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array('name' => 'required|unique:roles|min:3', 'description' => 'max:200');
        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails())
        {
            return response()->json();
        }
        else
        {
            $role = new Role;
            $role->name = Input::get('name');
            $role->description = Input::get('description');
            
            $role->save();
            return response()->json
        }
    }

    public function saveUserRoleAssignment()
    {
        $arrayUserRoleMapping = Input::get('userRoles');
        $users = User::all();
        $roles = Role::all();

        foreach ($users as $userkey => $user) {
            foreach ($roles as $roleKey => $role) {
                //If checkbox is clicked attach the role
                if(!empty($arrayUserRoleMapping[$userkey][$roleKey]))
                {
                    $user->attachRole($role);
                }
                //If checkbox is NOT clicked detatch the role
                elseif (empty($arrayUserRoleMapping[$userkey][$roleKey])) {
                    $user->detachRole($role);
                }
            }
        }

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array('name' => "required|unique:roles,name,$id|min:3", 'description' => 'max:200');
        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails())
        {
            return response()->json();
        }
        else
        {
            $role = Role::find($id);
            $role->name = Input::get('name');
            $role->description = Input::get('description');
            
            $role->save();
            return response()->json();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Soft delete the role
        $role = Role::find($id);
        $role->delete();
        
        // redirect
        return response()->json();

    }
}
