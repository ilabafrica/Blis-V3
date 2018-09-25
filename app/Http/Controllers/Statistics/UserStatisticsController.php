<?php

namespace App\Http\Controllers\Statistics;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserStatisticsController extends Controller
{
    public function getUsers(Request $request)
    {
        if ($request->query('user_id')) {
            $users = User::select('id', 'name', 'created_at')->where('id', '=', $request->query('user_id'))->get();
        } else {
            $users = User::select('id', 'name', 'created_at')->get();
        }

        return response()->json($users);
    }

    public function countUsers(Request $request)
    {
        if ($request->query('by_role')) {
            $users = DB::select('SELECT COUNT(*) as total, r.name, r.id FROM roles r, role_user ru WHERE r.id=ru.role_id GROUP BY r.id, r.name');
        } else {
            $users = User::count();
        }

        return response()->json($users);
    }

    public function logins(Request $request)
    {
        if ($request->query('user_id')) {
            $logins = DB::select('SELECT count(*) as total, MAX(created_at) as last_login, MIN(created_at) as first_login FROM oauth_access_tokens WHERE user_id='.$request->query('user_id'));
        } else {
            $logins = DB::table('oauth_access_tokens')->groupBy('user_id')->selectRaw('user_id, count(*) as total, MAX(created_at) as last_login, MIN(created_at) as first_login')->get();
        }

        return response()->json($logins);
    }
}
