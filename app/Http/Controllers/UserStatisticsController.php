<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserStatisticsController extends Controller
{
    public function getUsers(){
        // $tests = Test::count()->values('id')->groupBy('id');
        $users = User::all()->pluck('name','id');
        return response()->json($users);
    }
    public function logins(){
        $logins = DB::table('oauth_access_tokens')->groupBy('timing')->selectRaw('count(*) as total, DATE(created_at) as timing')->where('user_id','=',1)->get();
        return response()->json($logins);
    }
    public function logins2(){
        // $logins = DB::select('SELECT count(*) as total, DATE(created_at) as timing FROM  oauth_access_tokens where user_id=1 GROUP BY timing');
        // $logins = DB::table('oauth_access_tokens')->groupBy('user_id')->selectRaw('user_id, count(*) as total, MAX(created_at) as last_login, MIN(created_at) as first_login')->get();
        $logins = DB::select('SELECT u.id, u.name, u.created_at, oat.created_at as access_time FROM users u, oauth_access_tokens oat WHERE u.id = oat.user_id');
        return response()->json($logins);
    }
    //
    public function testsDoneByGender(Request $request)
    {
        $tests = DB::select('SELECT t.tested_by, p.gender_id, COUNT(DISTINCT t.id), DATE(t.time_started) as timing FROM patients p, tests t, encounters e WHERE p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.tested_by, p.gender_id, timing');
        return response()->json($tests);
    }
    //
    public function testsDone(Request $request)
    {
        $tests = User::find(1)->first()->testsDone()->get();        
        return response()->json($tests);
    }
    //
    public function testsDonePlusPatient(Request $request)
    {
        // $tests = DB::select('SELECT t.id, t.tested_by, DATE(t.time_started) as test_started_at, t.test_status_id, t.test_type_id, tt.name as test_type_name, g.code as gender_id, DATEDIFF(t.time_started, p.birth_date)/365.25 as age_at_test, e.location_id FROM patients p, tests t, encounters e, genders g, test_types tt WHERE p.id = e.patient_id AND t.encounter_id=e.id AND t.tested_by > 1 AND g.id = p.gender_id AND tt.id = t.test_type_id');
        // $tests = DB::select('SELECT t.id, t.tested_by, DATE(t.time_started) as test_started_at, t.test_status_id, t.test_type_id, g.code as gender_id, DATEDIFF(t.time_started, p.birth_date)/365.25 as age_at_test, e.location_id FROM patients p, tests t, encounters e, genders g WHERE p.id = e.patient_id AND t.encounter_id=e.id AND t.tested_by > 1 AND g.id = p.gender_id');
        $tests = DB::select('SELECT t.id, t.tested_by, DATE(t.time_started) as test_started_at, t.test_status_id, t.test_type_id, ttc.id as test_type_category_id, g.code as gender_id, DATEDIFF(t.time_started, p.birth_date)/365.25 as age_at_test, e.location_id FROM patients p, tests t, encounters e, genders g, test_types tt, test_type_categories ttc WHERE p.id = e.patient_id AND t.encounter_id=e.id AND t.tested_by >= 1 AND g.id = p.gender_id AND tt.id = t.test_type_id AND tt.test_type_category_id = ttc.id');
        return response()->json($tests);
    }
    public function testsVerified(Request $request)
    {
        //$tests = User::find(1)->first()->testsVerified()->get();     
        //SELECT t.test_type_id, p.gender_id, COUNT(DISTINCT t.id) FROM patients p, tests t, encounters e WHERE DATEDIFF(CURDATE(), p.`birth_date`)/365.25<5 AND t.tested_by=1 AND p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.test_type_id, p.gender_id   

        //SELECT t.tested_by, COUNT(DISTINCT t.id) FROM patients p, tests t, encounters e WHERE p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.tested_by
        $tests = User::find(1)->first()->testsVerified()->groupBy('timing')->select(DB::raw('count(*) as total, DATE(time_started) as timing'))->get();        
        return response()->json($tests);
    }
    public function testStatuses(){
        $test_statuses = DB::select("SELECT id, name, test_phase_id FROM test_statuses");
        return response()->json($test_statuses);
    }
    public function testTypes(){
        $test_types = DB::select("SELECT id, name, test_type_category_id as ttc_id FROM test_types");
        return response()->json($test_types);
    }
    public function testTypeCategories(){
        $test_type_categories = DB::select("SELECT id, name FROM test_type_categories");
        return response()->json($test_type_categories);
    }

    public function testsDoneTotals(){
        // $tests = Test::count()->values('id')->groupBy('id');
        $tests = DB::select('SELECT COUNT(*) as total, tested_by FROM tests GROUP BY tested_by');
        return response()->json($tests);
    }
    public function testsVerifiedTotals(){
        $tests = DB::select('SELECT COUNT(*) as total, verified_by FROM tests GROUP BY tested_by');
        return response()->json($tests);
    }
    
}

