<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class APIController extends Controller
{
    public function register()
    {
        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        return response($user->jsonSerialize(), Response::HTTP_CREATED);
    }

    public function login()
    {
        // Check if a user with the specified email exists
        $user = User::whereEmail(request('username'))->first();

        if (! $user) {

            //flash('Wrong email or password')->error();
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422,
            ], 422);
        }
        /*
         If a user with the email was found - check if the specified password
         belongs to this user
        */
        if (! \Hash::check(request('password'), $user->password)) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422,
            ], 422);
        }

        $secret = \DB::table('oauth_clients')
            ->where('id', env('PASSWORD_CLIENT_ID'))
            ->first()->secret;

        // Send an internal API request to get an access token
        $data = [
            'grant_type' => 'password',
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => $secret,
            'username' => request('username'),
            'password' => request('password'),
        ];

        $request = Request::create('/oauth/token', 'POST', $data);

        $response = app()->handle($request);

        if ($response->getStatusCode() != 200) {
            return response()->json([
                'message' => 'Wrong email or password',
                'status' => 422,
            ], 422);
        }

        // Get the data from the response
        $data = json_decode($response->getContent());

        // Format the final response in a desirable format
        return response()->json([
            'token' => $data->access_token,
            'user' => $user,
            'status' => 200,
        ]);
    }

    public function logout()
    {
        $accessToken = auth()->user()->token();

        $refreshToken = \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true,
            ]);

        $accessToken->revoke();

        return response()->json(['status' => 200]);
    }

    public function getUser()
    {
        return auth()->user()->load('roles.permissions');
    }
}
