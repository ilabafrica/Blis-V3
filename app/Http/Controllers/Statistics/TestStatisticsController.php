<?php

namespace App\Http\Controllers\Statistics;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TestStatisticsController extends Controller
{
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
        //SELECT t.test_type_id, p.gender_id, COUNT(DISTINCT t.id) FROM patients p, tests t, encounters e WHERE DATEDIFF(CURDATE(), p.`birth_date`)/365.25<5 AND t.tested_by=1 AND p.id = e.patient_id AND t.encounter_id=e.id GROUP BY t.test_type_id, p.gender_id   

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
        return response()->json($tests);
    }
    // get the total number of tests done grouped 
    public function testsDoneTotals(Request $request){
        if ($request->query('by_user') && $request->query('by_type')) { // grouped by user then by type
            $tests = DB::select("SELECT COUNT(*) as total, tested_by, test_type_id FROM tests WHERE test_status_id>=3 GROUP BY tested_by, test_type_id");
        }
        else if ($request->query('user_id') && $request->query('by_status')) { // All of particular user, grouped by status
            $tests = DB::select("SELECT COUNT(*) as total, test_status_id FROM tests WHERE tested_by=".$request->query('user_id')." GROUP BY test_status_id");
        }
        else if ($request->query('user_id') && $request->query('by_type')) { // All of particular user, grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests WHERE tested_by=".$request->query('user_id')." GROUP BY test_type_id");
        }
        else if ($request->query('user_id') && $request->query('by_gender')) { // All of particular user, grouped by gender
            //$tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests t, encounters e, patients p  WHERE tested_by=".$request->query('user_id')." GROUP BY test_type_id");
            $tests = DB::select("SELECT COUNT(*) as total, p.gender_id FROM tests t, encounters e, patients p  WHERE t.tested_by=".$request->query('user_id')." AND t.encounter_id=e.id AND e.patient_id = p.id GROUP BY p.gender_id");
        }
        else if ($request->query('user_id') && $request->query('by_category')) { // All of particular user, grouped by test category
            $tests = DB::select("SELECT COUNT(*) as total, tt.test_type_category_id as ttc_id FROM tests t, test_types tt WHERE tested_by=".$request->query('user_id')." AND t.test_type_id=tt.id GROUP BY ttc_id");
        }
        else if ($request->query('user_id') && $request->query('by_date')) { // All of particular user, grouped by date
            $tests = DB::select("SELECT COUNT(*) as total, DATE(time_started) as timing FROM tests t WHERE tested_by=".$request->query('user_id')." GROUP BY timing");
        }
        else if ($request->query('by_user')) { // grouped by user
            $tests = DB::select("SELECT COUNT(*) as total, tested_by FROM tests WHERE test_status_id>=3 GROUP BY tested_by");
        }
        else if ($request->query('by_type')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests WHERE test_status_id>=3 GROUP BY test_type_id");
        }
        else if ($request->query('by_date')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, DATE(time_started) as timing FROM tests WHERE test_status_id>=3 GROUP BY timing");
        }
        else if ($request->query('user_id')) { // grouped by particular user
            $tests = DB::select("SELECT COUNT(*) as total, tested_by FROM tests WHERE tested_by=".$request->query('user_id')." AND test_status_id>=3 GROUP BY tested_by");
        }
        else if ($request->query('by_status')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_status_id FROM tests WHERE test_status_id>=3 GROUP BY test_status_id");
        }
        else if ($request->query('by_gender')) { // grouped by gender
            $tests = DB::select("SELECT COUNT(*) as total, p.gender_id FROM tests t, encounters e, patients p  WHERE t.test_status_id>=3 AND t.encounter_id=e.id AND e.patient_id = p.id GROUP BY p.gender_id");
        }
        else if ($request->query('by_category')) { // grouped by category
            $tests = DB::select("SELECT COUNT(*) as total, tt.test_type_category_id FROM tests t, test_types tt WHERE t.test_type_id=tt.id AND t.test_status_id>=3 GROUP BY tt.test_type_category_id");
        }
        else{
            $tests = DB::select("SELECT COUNT(*) as total, tested_by FROM tests WHERE test_status_id>=3 GROUP BY tested_by");
        }     
        return response()->json($tests);
    }
    // get the total number of tests verified grouped by whom they were verified by
    public function testsVerifiedTotals(Request $request){
        if ($request->query('by_user') && $request->query('by_type')) { // grouped by user then by type
            $tests = DB::select("SELECT COUNT(*) as total, verified_by, test_type_id FROM tests WHERE test_status_id=4 GROUP BY verified_by, test_type_id");
        }
        else if ($request->query('user_id') && $request->query('by_status')) { // All of particular user, grouped by status
            $tests = DB::select("SELECT COUNT(*) as total, test_status_id FROM tests WHERE verified_by=".$request->query('user_id')." GROUP BY test_status_id");
        }
        else if ($request->query('user_id') && $request->query('by_type')) { // All of particular user, grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests WHERE verified_by=".$request->query('user_id')." GROUP BY test_type_id");
        }
        else if ($request->query('user_id') && $request->query('by_gender')) { // All of particular user, grouped by gender
            //$tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests t, encounters e, patients p  WHERE verified_by=".$request->query('user_id')." GROUP BY test_type_id");
            $tests = DB::select("SELECT COUNT(*) as total, p.gender_id FROM tests t, encounters e, patients p  WHERE t.verified_by=".$request->query('user_id')." AND t.encounter_id=e.id AND e.patient_id = p.id GROUP BY p.gender_id");
        }
        else if ($request->query('user_id') && $request->query('by_category')) { // All of particular user, grouped by test category
            $tests = DB::select("SELECT COUNT(*) as total, tt.test_type_category_id as ttc_id FROM tests t, test_types tt WHERE verified_by=".$request->query('user_id')." AND t.test_type_id=tt.id GROUP BY ttc_id");
        }
        else if ($request->query('user_id') && $request->query('by_date')) { // All of particular user, grouped by date
            $tests = DB::select("SELECT COUNT(*) as total, DATE(time_started) as timing FROM tests t WHERE verified_by=".$request->query('user_id')." GROUP BY timing");
        }
        else if ($request->query('by_user')) { // grouped by user
            $tests = DB::select("SELECT COUNT(*) as total, verified_by FROM tests WHERE test_status_id=4 GROUP BY verified_by");
        }
        else if ($request->query('by_type')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_type_id FROM tests WHERE test_status_id=4 GROUP BY test_type_id");
        }
        else if ($request->query('by_date')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, DATE(time_started) as timing FROM tests WHERE test_status_id=4 GROUP BY timing");
        }
        else if ($request->query('user_id')) { // grouped by particular user
            $tests = DB::select("SELECT COUNT(*) as total, verified_by FROM tests WHERE verified_by=".$request->query('user_id')." AND test_status_id=4 GROUP BY verified_by");
        }
        else if ($request->query('by_status')) { // grouped by type
            $tests = DB::select("SELECT COUNT(*) as total, test_status_id FROM tests WHERE test_status_id=4 GROUP BY test_status_id");
        }
        else if ($request->query('by_gender')) { // grouped by gender
            $tests = DB::select("SELECT COUNT(*) as total, p.gender_id FROM tests t, encounters e, patients p  WHERE t.test_status_id=4 AND t.encounter_id=e.id AND e.patient_id = p.id GROUP BY p.gender_id");
        }
        else if ($request->query('by_category')) { // grouped by category
            $tests = DB::select("SELECT COUNT(*) as total, tt.test_type_category_id FROM tests t, test_types tt WHERE t.test_type_id=tt.id AND t.test_status_id=4 GROUP BY tt.test_type_category_id");
        }
        else{
            $tests = DB::select("SELECT COUNT(*) as total, verified_by FROM tests WHERE test_status_id=4 GROUP BY verified_by");
        }     
        return response()->json($tests);
    }

    // get the total number of tests grouped Query experiment
    public function testsTotalsExp(Request $request){
        $selects = 'COUNT(*) as total'; $tables = 'tests t'; $wheres = '1'; $group_bys='';
        // By Users
        if ($request->query('user_id')) { // grouped by particular user
            $selects = $selects. ", t.created_by";
            $wheres = $wheres . " AND t.created_by=".$request->query('user_id');
            $group_bys = $group_bys. ", t.created_by";
        }
        else if ($request->query('by_user')) { // grouped by users
            $selects = $selects. ", t.created_by";
            $group_bys = $group_bys. ", t.created_by";
        }
        // By Status
        if ($request->query('test_status')) { // grouped by particular status
            $selects = $selects. ", t.test_status_id";
            $wheres = $wheres . " AND t.test_status_id=".$request->query('test_status');
            $group_bys = $group_bys. ", t.test_status_id";
        }
        else if ($request->query('by_status')) { // grouped by status
            $selects = $selects. ", t.test_status_id";
            $group_bys = $group_bys. ", t.test_status_id";
        }
        // By Type
        if ($request->query('test_type')) { // grouped by type
            $selects = $selects. ", t.test_type_id";
            $wheres = $wheres . " AND t.test_type_id=".$request->query('test_type');
            $group_bys = $group_bys. ", t.test_type_id";
        }
        else if ($request->query('by_type')) { // grouped by type
            $selects = $selects. ", t.test_type_id";
            $group_bys = $group_bys. ", t.test_type_id";
        }
        // By Date
        if($request->query('before_date') || $request->query('at_date') || $request->query('after_date')){ // group by particular date(s)
            if($request->query('at_date') && $this->checkmydate($request->query('at_date'))){ //group by particular date
                $selects = $selects. ", DATE(t.time_started) as timing";
                $wheres = $wheres . " AND DATE(t.time_started)='".$request->query('at_date')."'";
                $group_bys = $group_bys. ", timing";
            }else{
                if($request->query('before_date') && $this->checkmydate($request->query('before_date')) && $request->query('after_date') && $this->checkmydate($request->query('after_date'))){
                    $selects = $selects. ", DATE(t.time_started) as timing";
                    $wheres = $wheres . " AND DATE(t.time_started)<'".$request->query('before_date')."' AND DATE(t.time_started)>'".$request->query('after_date')."'";
                    $group_bys = $group_bys. ", timing";
                }
                else{
                    if($request->query('before_date') && $this->checkmydate($request->query('before_date'))){
                        $selects = $selects. ", DATE(t.time_started) as timing";
                        $wheres = $wheres . " AND DATE(t.time_started)<'".$request->query('before_date')."'";
                        $group_bys = $group_bys. ", timing";
                    }
                    else if($request->query('after_date') && $this->checkmydate($request->query('after_date'))){
                        $selects = $selects. ", DATE(t.time_started) as timing";
                        $wheres = $wheres . " AND DATE(t.time_started)>'".$request->query('after_date')."'";
                        $group_bys = $group_bys. ", timing";
                    }
                }
            }
        }
        else if ($request->query('by_date')) { // grouped by date
            $selects = $selects. ", DATE(t.time_started) as timing";
            $group_bys = $group_bys. ", timing";
        }
        if($request->query('location_id')||$request->query('by_location') || $request->query('gender_id') || $request->query('by_gender')){
            $tables = $tables. ", encounters e";
            $wheres = $wheres . " AND t.encounter_id=e.id";
        }
        // By Location
        if ($request->query('location_id')) { // grouped by particular test category
            $selects = $selects. ", e.location_id";
            $wheres = $wheres . " AND t.encounter_id = e.id AND e.location_id=".$request->query('location_id');
            $group_bys = $group_bys. ", e.location_id";
        }        
        else if ($request->query('by_location')) { // grouped by test category
            $selects = $selects. ", e.location_id";
            $wheres = $wheres . " AND t.encounter_id = e.id";
            $group_bys = $group_bys. ", e.location_id";
        }  
        // By Gender
        if ($request->query('gender_id')) { // grouped by particular gender
            $selects = $selects. ", p.gender_id";
            $tables = $tables. ", patients p";
            $wheres = $wheres . " AND e.patient_id = p.id AND p.gender_id=".$request->query('gender_id');
            $group_bys = $group_bys. ", p.gender_id";
        }
        else if ($request->query('by_gender')) { // grouped by gender
            $selects = $selects. ", p.gender_id";
            $tables = $tables. ", patients p";
            $wheres = $wheres . " AND e.patient_id = p.id";
            $group_bys = $group_bys. ", p.gender_id";
        }
        // By Category
        if ($request->query('category_id')) { // grouped by particular test category
            $selects = $selects. ", tt.test_type_category_id as ttc_id";
            $tables = $tables. ", test_types tt";
            $wheres = $wheres . " AND t.test_type_id=tt.id AND tt.test_type_category_id=".$request->query('category_id');
            $group_bys = $group_bys. ", ttc_id";
        }        
        else if ($request->query('by_category')) { // grouped by test category
            $selects = $selects. ", tt.test_type_category_id as ttc_id";
            $tables = $tables. ", test_types tt";
            $wheres = $wheres . " AND t.test_type_id=tt.id";
            $group_bys = $group_bys. ", ttc_id";
        }  
        if($request->query('with_ids')){
            $selects = $selects. ", GROUP_CONCAT(t.id) as ids";            
        }     
        // return response()->json("SELECT ".$selects." FROM ".$tables." WHERE ".$wheres);
        if($group_bys){ // is there anything to group by? if yes then
            $tests = DB::select("SELECT ".$selects." FROM ".$tables." WHERE ".$wheres." GROUP BY ".substr($group_bys, 1));
        }else{
            $tests = DB::select("SELECT ".$selects." FROM ".$tables." WHERE ".$wheres);
        }
        return response()->json($tests);
    }

    public function checkmydate($date) { // date passed in yyyy-mm-dd or yyyy/mm/dd format
        $tempDate = explode('-', $date); // try date format seperated by - i.e. yyyy-mm-dd
        // checkdate(month, day, year)
        if(count($tempDate)!=3){
            $tempDate = explode('/', $date); // try format seperated by / i.e.  yyyy/mm/dd
            if(count($tempDate)!=3){
                return false;                
            }
        }
        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }

    public function isdateGreaterThan($before_date, $after_date){
        $date1=date_create($before_date);
        $date2=date_create($after_date);
        $diff=date_diff($date1,$date2);

        return $diff->format("%R%a days");
    }
}
