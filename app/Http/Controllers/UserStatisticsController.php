<?php

namespace App\Http\Controllers;

use App\User;
use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserStatisticsController extends Controller
{
    //
    public function testsDone(Request $request)
    {
        $tests = User::find(1)->first()->testsDone()->get();        
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
}
