<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserStatisticsController extends Controller
{
    public function getUsers(){        
        $users = User::select('id','name','created_at')->get();
        return response()->json($users);
    }
    public function logins(){
        $logins = DB::table('oauth_access_tokens')->groupBy('timing')->selectRaw('count(*) as total, DATE(created_at) as timing')->where('user_id','=',1)->get();
        return response()->json($logins);
    }
    public function logins2(){
        $logins = DB::table('oauth_access_tokens')->groupBy('user_id')->selectRaw('user_id, count(*) as total, MAX(created_at) as last_login, MIN(created_at) as first_login')->get();        
        return response()->json($logins);
    }
    public function getGenders(){
        $genders = DB::select("SELECT * FROM genders WHERE 1");        
        return response()->json($genders);
    }
    //
    public function testsDoneByGender(Request $request)
    {
        if($request->query('by_date')){
            $tests = DB::select("SELECT t.tested_by, p.gender_id, COUNT(DISTINCT t.id) as total, DATE(t.time_started) as timing FROM patients p, tests t, encounters e WHERE p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.tested_by, p.gender_id, timing");
        }
        if($request->query('by_user')){
            $tests = DB::select("SELECT t.tested_by, p.gender_id, COUNT(DISTINCT t.id) as total FROM patients p, tests t, encounters e WHERE p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.tested_by, p.gender_id");
        }else{
            $tests = DB::select("SELECT p.gender_id, COUNT(DISTINCT t.id) as total FROM patients p, tests t, encounters e WHERE p.id = e.patient_id AND t.encounter_id=e.id GROUP BY p.gender_id");
        }
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
        if ($request->query('user_id')) {
            $tests = DB::select("SELECT t.id, t.tested_by, DATE(t.time_started) as test_started_at, t.test_status_id, t.test_type_id, ttc.id as test_type_category_id, g.code as gender_id, DATEDIFF(t.time_started, p.birth_date)/365.25 as age_at_test, e.location_id FROM patients p, tests t, encounters e, genders g, test_types tt, test_type_categories ttc WHERE p.id = e.patient_id AND t.encounter_id=e.id AND t.tested_by =". intval($request->query('user_id'))." AND g.id = p.gender_id AND tt.id = t.test_type_id AND tt.test_type_category_id = ttc.id");
        }
        else{
            $tests = DB::select('SELECT t.id, t.tested_by, DATE(t.time_started) as test_started_at, t.test_status_id, t.test_type_id, ttc.id as test_type_category_id, g.code as gender_id, DATEDIFF(t.time_started, p.birth_date)/365.25 as age_at_test, e.location_id FROM patients p, tests t, encounters e, genders g, test_types tt, test_type_categories ttc WHERE p.id = e.patient_id AND t.encounter_id=e.id AND t.tested_by >= 1 AND g.id = p.gender_id AND tt.id = t.test_type_id AND tt.test_type_category_id = ttc.id');
        }
        return response()->json($tests);
    }
    public function testsVerified(Request $request)
    {
        //$tests = User::find(1)->first()->testsVerified()->get();     
        //SELECT t.test_type_id, p.gender_id, COUNT(DISTINCT t.id) FROM patients p, tests t, encounters e WHERE DATEDIFF(CURDATE(), p.`birth_date`)/365.25<5 AND t.tested_by=1 AND p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.test_type_id, p.gender_id   

        // SELECT t.tested_by, COUNT(DISTINCT t.id) FROM patients p, tests t, encounters e WHERE p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.tested_by
        // $tests = User::find(1)->first()->testsVerified()->groupBy('timing')->select(DB::raw('count(*) as total, DATE(time_started) as timing'))->get();        
        $tests = DB::select("SELECT count(*) as total, DATE(time_started) as timing FROM tests WHERE verified_by=1");
        return response()->json($tests);
    }
    // get the basic information per test type status
    public function testStatuses(){
        $test_statuses = DB::select("SELECT id, name, test_phase_id FROM test_statuses");
        return response()->json($test_statuses);
    }
    // get the basic information per test type
    public function testTypes(){
        $test_types = DB::select("SELECT id, name, test_type_category_id as ttc_id FROM test_types");
        return response()->json($test_types);
    }
    // get the basic information per test type category
    public function testTypeCategories(){
        $test_type_categories = DB::select("SELECT id, name FROM test_type_categories");
        return response()->json($test_type_categories);
    }
    // get the total number of tests grouped 
    public function testsTotals(Request $request){
        if ($request->query('by_user') && $request->query('by_type')) { // grouped by user then by type
            $tests = DB::select("SELECT COUNT(*) as total, created_by, test_type_id FROM tests GROUP BY created_by, test_type_id");
        }
        else if ($request->query('user_id') && $request->query('by_status')) { // All of particular user, grouped by status
            $tests = DB::select("SELECT COUNT(*) as total, test_status_id FROM tests WHERE created_by=".$request->query('user_id')." GROUP BY test_status_id");
        }
        else if ($request->query('user_id') && $request->query('by_type')) { // All of particular user, grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests WHERE created_by=".$request->query('user_id')." GROUP BY test_type_id");
        }
        else if ($request->query('user_id') && $request->query('by_gender')) { // All of particular user, grouped by gender
            //$tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests t, encounters e, patients p  WHERE created_by=".$request->query('user_id')." GROUP BY test_type_id");
            $tests = DB::select("SELECT COUNT(*) as total, p.gender_id FROM tests t, encounters e, patients p  WHERE t.created_by=".$request->query('user_id')." AND t.encounter_id=e.id AND e.patient_id = p.id GROUP BY p.gender_id");
        }
        else if ($request->query('user_id') && $request->query('by_category')) { // All of particular user, grouped by test category
            $tests = DB::select("SELECT COUNT(*) as total, tt.test_type_category_id as ttc_id FROM tests t, test_types tt WHERE created_by=".$request->query('user_id')." AND t.test_type_id=tt.id GROUP BY ttc_id");
        }
        else if ($request->query('user_id') && $request->query('by_date')) { // All of particular user, grouped by date
            $tests = DB::select("SELECT COUNT(*) as total, DATE(time_started) as timing FROM tests t WHERE created_by=".$request->query('user_id')." GROUP BY timing");
        }
        else if ($request->query('by_user')) { // grouped by user
            $tests = DB::select("SELECT COUNT(*) as total, created_by FROM tests GROUP BY created_by");
        }
        else if ($request->query('by_type')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests GROUP BY test_type_id");
        }
        else if ($request->query('by_date')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, DATE(time_started) as timing FROM tests GROUP BY timing");
        }
        else if ($request->query('user_id')) { // grouped by particular user
            $tests = DB::select("SELECT COUNT(*) as total, created_by FROM tests WHERE created_by=".$request->query('user_id')." GROUP BY created_by");
        }
        else if ($request->query('by_status')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_status_id FROM tests GROUP BY test_status_id");
        }
        else if ($request->query('by_gender')) { // grouped by gender
            $tests = DB::select("SELECT COUNT(*) as total, p.gender_id FROM tests t, encounters e, patients p  WHERE t.encounter_id=e.id AND e.patient_id = p.id GROUP BY p.gender_id");
        }
        else if ($request->query('by_category')) { // grouped by category
            $tests = DB::select("SELECT COUNT(*) as total, tt.test_type_category_id FROM tests t, test_types tt WHERE t.test_type_id=tt.id GROUP BY tt.test_type_category_id");
        }
        else{
            $tests = DB::select("SELECT COUNT(*) as total FROM tests");
        }
        return $tests;
    }
    // get the total number of tests done grouped 
    public function testsDoneTotals(Request $request){
        if ($request->query('user_id') && $request->query('by_type')) { // of a particular user id and grouped by a type
            $tests = DB::select("SELECT COUNT(*) as total, tested_by, test_type_id FROM tests WHERE tested_by=".$request->query('user_id')." GROUP BY tested_by, test_type_id");
        }
        else if ($request->query('by_user') && $request->query('by_type')) { // grouped by user then by type
            $tests = DB::select("SELECT COUNT(*) as total, tested_by, test_type_id FROM tests WHERE tested_by=".$request->query('user_id')." GROUP BY tested_by,test_type_id");
        }
        else if ($request->query('user_id')) { // by a particular user id
            $tests = DB::select("SELECT COUNT(*) as total, tested_by FROM tests WHERE tested_by=".$request->query('user_id')." GROUP BY tested_by");
        }
        else{ // by whom they were done by
            $tests = DB::select("SELECT COUNT(*) as total, tested_by FROM tests GROUP BY tested_by");
        }        
        return response()->json($tests);
    }
    // get the total number of tests verified grouped by whom they were verified by
    public function testsVerifiedTotals(Request $request){
        if ($request->query('user_id') && $request->query('by_type')) { // of a particular user id and grouped by a type
            $tests = DB::select("SELECT COUNT(*) as total, verified_by, test_type_id FROM tests WHERE verified_by=".$request->query('user_id')." GROUP BY verified_by, test_type_id");
        }
        else if ($request->query('by_user') && $request->query('by_type')) { // grouped by user then by type
            $tests = DB::select("SELECT COUNT(*) as total, verified_by, test_type_id FROM tests WHERE verified_by=".$request->query('user_id')." GROUP BY verified_by,test_type_id");
        }
        else if ($request->query('user_id')) { // by a particular user id
            $tests = DB::select("SELECT COUNT(*) as total, verified_by FROM tests WHERE verified_by=".$request->query('user_id')." GROUP BY verified_by");
        }
        else{ // by whom they were done by
            $tests = DB::select("SELECT COUNT(*) as total, verified_by FROM tests GROUP BY verified_by");
        }        
        return response()->json($tests);
    }
    
}

