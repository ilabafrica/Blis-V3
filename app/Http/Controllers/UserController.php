<?php

namespace App\Http\Controllers;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead     - Emmanuel Kweyu.
 * Devs      - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma.
 * More Devs     - Derrick Rono|Anthony Ereng|Emmanuel Kitsao.
 */

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('search')) {
            $search = $request->query('search');
            $user = User::where('username', 'LIKE', "%{$search}%")
                ->paginate(10);
        } else {
            $user = User::paginate(10);
        }

        return response()->json($user);
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
            'name'     => 'required',
            'username' => 'required',
            'email'    => 'required',
            //'password' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator,422);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = bcrypt('mydefaultpassword');
            //$user->remember_token = $request->input('remember_token');

            try {
                $user->save();

                return response()->json($user);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /*public function profile()
    {
        $user = Auth::user();

        return response()->json($user);
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $rules = [
            'name' => 'required',
            'email' => 'required',
            //'password' => 'required',

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            $user = User::findOrFail($id);
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            if($request->input('passwordChange')){
                if (! \Hash::check(request('password'), $user->password)) {
                    return response()->json([
                        'message' => 'Wrong password',
                        'status' => 422,
                    ], 422);
                }
            $user->password = bcrypt($request->input('newpassword'));
            
            }
            if($request->input('adminPasswordChange')){
                $user->password = bcrypt($request->input('password'));
            }
            if($request->input('removePic')){
                $user->profile_picture = null;
            }
            //$user->remember_token = $request->input('remember_token');
            //$user->remember_token = $request->input('remember_token');

            try {
                $user->save();

                return response()->json($user);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
            }
        }
    }

    public function profilepic (Request $request)
    {
        $rules = [
            'file' => 'image:jpeg,jpg,png',
            'id' => 'required',
            'name' => 'required'

        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator, 422);
        } else {
            if ($request->file('file')->isValid()) {
                $destinationPath = 'uploads/profile_pictures';
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileName = rand(11111,99999).'.'.$extension;
                $request->file('file')->move($destinationPath, $fileName);
                }  
            $user = User::findOrFail($request->input('id'));
            $user->profile_picture = $fileName;
            try {
                $user->save();

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
    public function destroy($id)
    {
        try {
            return response()->json(User::destroy($id), 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
