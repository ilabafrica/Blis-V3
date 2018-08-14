<?php

namespace App\Http\Controllers\Statistics;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TestStatisticsController extends Controller
{    
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
    // get the total number of tests grouped Query
    public function testsTotals(Request $request){
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
        // By User who tested it
        if ($request->query('tested_by')) { // grouped by particular user
            $selects = $selects. ", t.tested_by";
            $wheres = $wheres . " AND t.test_status_id>=3 AND t.tested_by=".$request->query('tested_by');
            $group_bys = $group_bys. ", t.tested_by";
        }
        else if ($request->query('by_tester')) { // grouped by user who tested 
            $selects = $selects. ", t.tested_by";
            $wheres = $wheres . " AND t.test_status_id>=3";
            $group_bys = $group_bys. ", t.tested_by";
        }
        // By User who verified it
        if ($request->query('verified_by')) { // grouped by particular user
            $selects = $selects. ", t.verified_by";
            $wheres = $wheres . " AND t.test_status_id=4 AND t.verified_by=".$request->query('verified_by');
            $group_bys = $group_bys. ", t.verified_by";
        }
        else if ($request->query('by_verifier')) { // grouped by user who tested 
            $selects = $selects. ", t.verified_by";
            $wheres = $wheres . " AND t.test_status_id=4";
            $group_bys = $group_bys. ", t.verified_by";
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
        // By Date Created
        if($request->query('created_before_date') || $request->query('created_at_date') || $request->query('created_after_date')){ // group by particular date(s)
            if($request->query('created_at_date') && $this->checkmydate($request->query('created_at_date'))){ //group by particular date
                $selects = $selects. ", DATE(t.created_at) as test_created_at";
                $wheres = $wheres . " AND DATE(t.created_at)='".$request->query('at_date')."'";
                $group_bys = $group_bys. ", test_created_at";
            }else{
                if($request->query('created_before_date') && $this->checkmydate($request->query('created_before_date')) && $request->query('created_after_date') && $this->checkmydate($request->query('created_after_date'))){
                    $selects = $selects. ", DATE(t.created_at) as test_created_at";
                    $wheres = $wheres . " AND DATE(t.created_at)<'".$request->query('created_before_date')."' AND DATE(t.created_at)>'".$request->query('created_after_date')."'";
                    $group_bys = $group_bys. ", test_created_at";
                }
                else{
                    if($request->query('created_before_date') && $this->checkmydate($request->query('created_before_date'))){
                        $selects = $selects. ", DATE(t.created_at) as test_created_at";
                        $wheres = $wheres . " AND DATE(t.created_at)<'".$request->query('created_before_date')."'";
                        $group_bys = $group_bys. ", test_created_at";
                    }
                    else if($request->query('created_after_date') && $this->checkmydate($request->query('created_after_date'))){
                        $selects = $selects. ", DATE(t.created_at) as test_created_at";
                        $wheres = $wheres . " AND DATE(t.created_at)>'".$request->query('created_after_date')."'";
                        $group_bys = $group_bys. ", test_created_at";
                    }
                }
            }
        }
        else if ($request->query('by_date_created')) { // grouped by date created
            $selects = $selects. ", DATE(t.created_at) as test_created_at";
            $group_bys = $group_bys. ", test_created_at";
        }
        // By Date Started
        if($request->query('started_before_date') || $request->query('started_at_date') || $request->query('started_after_date')){ // group by particular date(s)
            if($request->query('started_at_date') && $this->checkmydate($request->query('started_at_date'))){ //group by particular date
                $selects = $selects. ", DATE(t.time_started) as test_started_at";
                $wheres = $wheres . " AND DATE(t.time_started)='".$request->query('started_at_date')."'";
                $group_bys = $group_bys. ", test_started_at";
            }else{
                if($request->query('before_date') && $this->checkmydate($request->query('started_before_date')) && $request->query('started_after_date') && $this->checkmydate($request->query('started_after_date'))){
                    $selects = $selects. ", DATE(t.time_started) as test_started_at";
                    $wheres = $wheres . " AND DATE(t.time_started)<'".$request->query('started_before_date')."' AND DATE(t.time_started)>'".$request->query('started_after_date')."'";
                    $group_bys = $group_bys. ", test_started_at";
                }
                else{
                    if($request->query('started_before_date') && $this->checkmydate($request->query('started_before_date'))){
                        $selects = $selects. ", DATE(t.time_started) as test_started_at";
                        $wheres = $wheres . " AND DATE(t.time_started)<'".$request->query('started_before_date')."'";
                        $group_bys = $group_bys. ", test_started_at";
                    }
                    else if($request->query('started_after_date') && $this->checkmydate($request->query('started_after_date'))){
                        $selects = $selects. ", DATE(t.time_started) as test_started_at";
                        $wheres = $wheres . " AND DATE(t.time_started)>'".$request->query('started_after_date')."'";
                        $group_bys = $group_bys. ", test_started_at";
                    }
                }
            }
        }
        else if ($request->query('by_date_started')) { // grouped by date started
            $selects = $selects. ", DATE(t.time_started) as test_started_at";
            $group_bys = $group_bys. ", test_started_at";
        }
        // By Date Completed
        if($request->query('completed_before_date') || $request->query('completed_at_date') || $request->query('completed_after_date')){ // group by particular date(s)
            if($request->query('completed_at_date') && $this->checkmydate($request->query('completed_at_date'))){ //group by particular date
                $selects = $selects. ", DATE(t.time_completed) as test_completed_at";
                $wheres = $wheres . " AND DATE(t.time_completed)='".$request->query('completed_at_date')."'";
                $group_bys = $group_bys. ", test_completed_at";
            }else{
                if($request->query('completed_before_date') && $this->checkmydate($request->query('completed_before_date')) && $request->query('completed_after_date') && $this->checkmydate($request->query('completed_after_date'))){
                    $selects = $selects. ", DATE(t.time_completed) as test_completed_at";
                    $wheres = $wheres . " AND DATE(t.time_completed)<'".$request->query('completed_before_date')."' AND DATE(t.time_completed)>'".$request->query('completed_after_date')."'";
                    $group_bys = $group_bys. ", test_completed_at";
                }
                else{
                    if($request->query('completed_before_date') && $this->checkmydate($request->query('completed_before_date'))){
                        $selects = $selects. ", DATE(t.time_completed) as test_completed_at";
                        $wheres = $wheres . " AND DATE(t.time_completed)<'".$request->query('completed_before_date')."'";
                        $group_bys = $group_bys. ", test_completed_at";
                    }
                    else if($request->query('completed_after_date') && $this->checkmydate($request->query('completed_after_date'))){
                        $selects = $selects. ", DATE(t.time_completed) as test_completed_at";
                        $wheres = $wheres . " AND DATE(t.time_completed)>'".$request->query('completed_after_date')."'";
                        $group_bys = $group_bys. ", test_completed_at";
                    }
                }
            }
        }
        else if ($request->query('by_date_completed')) { // grouped by date completed
            $selects = $selects. ", DATE(t.time_completed) as test_completed_at";
            $group_bys = $group_bys. ", test_completed_at";
        }
        // By Date Verified
        if($request->query('verified_before_date') || $request->query('verified_at_date') || $request->query('verified_after_date')){ // group by particular date(s)
            if($request->query('verified_at_date') && $this->checkmydate($request->query('verified_at_date'))){ //group by particular date
                $selects = $selects. ", DATE(t.time_verified) as test_verified_at";
                $wheres = $wheres . " AND DATE(t.time_verified)='".$request->query('verified_at_date')."'";
                $group_bys = $group_bys. ", test_verified_at";
            }else{
                if($request->query('verified_before_date') && $this->checkmydate($request->query('verified_before_date')) && $request->query('verified_after_date') && $this->checkmydate($request->query('verified_after_date'))){
                    $selects = $selects. ", DATE(t.time_verified) as test_verified_at";
                    $wheres = $wheres . " AND DATE(t.time_verified)<'".$request->query('verified_before_date')."' AND DATE(t.time_verified)>'".$request->query('verified_after_date')."'";
                    $group_bys = $group_bys. ", test_verified_at";
                }
                else{
                    if($request->query('verified_before_date') && $this->checkmydate($request->query('verified_before_date'))){
                        $selects = $selects. ", DATE(t.time_verified) as test_verified_at";
                        $wheres = $wheres . " AND DATE(t.time_verified)<'".$request->query('verified_before_date')."'";
                        $group_bys = $group_bys. ", test_verified_at";
                    }
                    else if($request->query('verified_after_date') && $this->checkmydate($request->query('verified_after_date'))){
                        $selects = $selects. ", DATE(t.time_verified) as test_verified_at";
                        $wheres = $wheres . " AND DATE(t.time_verified)>'".$request->query('verified_after_date')."'";
                        $group_bys = $group_bys. ", test_verified_at";
                    }
                }
            }
        }
        else if ($request->query('by_date_verified')) { // grouped by date verified
            $selects = $selects. ", DATE(t.time_verified) as test_verified_at";
            $group_bys = $group_bys. ", test_verified_at";
        }
        
        // By TurnAround Time
        if ($request->query('with_tat')) { // grouped by patient ages
            $selects = $selects. ", AVG(TIMESTAMPDIFF(MINUTE,t.time_started,t.time_completed)) as avg_tat,  SUM(IF(TIMESTAMPDIFF(MINUTE,t.time_started,t.time_completed) <= 20,1,0)) as 'lte_20', SUM(IF( TIMESTAMPDIFF(MINUTE,t.time_started,t.time_completed) BETWEEN 20 and 60,1,0)) as '20_to_60', SUM(IF( TIMESTAMPDIFF(MINUTE,t.time_started,t.time_completed)>=60,1,0)) as 'gte_60'";
            $wheres = $wheres . " AND t.time_completed IS NOT NULL";
        }
        // Encounters table addition into query with where class in relation to tests table
        if($request->query('location_id')||$request->query('by_location') || $request->query('gender_id') || $request->query('by_gender') || $request->query('by_age') || $request->query('age_group') || $request->query('patient_id') || $request->query('by_patient')){
            $tables = $tables. ", encounters e";
            $wheres = $wheres . " AND t.encounter_id=e.id";
            if($request->query('gender_id') || $request->query('by_gender') || $request->query('by_age') || $request->query('age_group') || $request->query('patient_id') || $request->query('by_patient')){ //  Patients table addition into query with where class in relation to encounters table
                $tables = $tables. ", patients p";
                $wheres = $wheres . " AND e.patient_id = p.id";
            }
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
        // By Patient
        if ($request->query('patient_id')) { // grouped by particular gender
            $selects = $selects. ", p.id as patient_id";
            $wheres = $wheres . " AND p.id=".$request->query('patient_id');
            $group_bys = $group_bys. ", p.id";
        }
        else if ($request->query('by_patient')) { // grouped by gender
            $selects = $selects. ", p.id as patient_id";
            $group_bys = $group_bys. ", p.id";
        }
        // By Gender
        if ($request->query('gender_id')) { // grouped by particular gender
            $selects = $selects. ", p.gender_id";
            $wheres = $wheres . " AND p.gender_id=".$request->query('gender_id');
            $group_bys = $group_bys. ", p.gender_id";
        }
        else if ($request->query('by_gender')) { // grouped by gender
            $selects = $selects. ", p.gender_id";
            $group_bys = $group_bys. ", p.gender_id";
        }
        // By Patient age
        if ($request->query('by_age')) { // grouped by patient ages
            $selects = $selects. ",  SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 <= 5,1,0)) as 'under_5', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 BETWEEN 5 and 20,1,0)) as '5_to_20', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25>=20,1,0)) as 'over_20'";            
        }else if ($request->query('age_group')) { // grouped by patient ages
            $ages = explode(',', $request->query('age_group'));
            if(count($ages)==2 && is_numeric($ages[0]) && is_numeric($ages[1])){
                $ages[0] = intval($ages[0]);
                $ages[1] = intval($ages[1]);
                // dd($ages);
                $selects = $selects. ",  SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 <=".$ages[0].",1,0)) as 'under_".$ages[0]."', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 BETWEEN ".$ages[0]." and ".$ages[1].",1,0)) as '".$ages[0]."_to_".$ages[1]."', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25>=".$ages[1].",1,0)) as 'over_".$ages[1]."'";            
            }
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
        // $time_started =  date('Y-m-d H:i:s',strtotime("-".rand(1,10)." days"));
        // return date('Y-m-d H:i:s',strtotime($time_started."+".rand(10,3600)." minutes"));
        // return date('Y-m-d H:i:s',strtotime("+".rand(10,1000)." minutes"));
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
