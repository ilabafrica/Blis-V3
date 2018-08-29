<?php

namespace App\Http\Controllers\Statistics;

use App\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResultsStatisticsController extends Controller
{
    // get the alphanumeric counts
    public function alphanumericCounts(Request $request){
        if($request->query('with_categories')){
            $alphanumeric_counts = DB::select("SELECT COUNT(DISTINCT e.id) as totalEncounters,COUNT(DISTINCT r.id) as totalResults, COUNT(DISTINCT t.id) as totalTests, m.name as measureName, m.id as measureId, mr.display, ttc.name as categoryName FROM encounters e, tests t, results r, measures m, measure_ranges mr, test_types tt, test_type_categories ttc WHERE t.encounter_id = e.id and r.test_id=t.id and r.measure_id = m.id and m.measure_type_id = 2 and mr.display = r.result and t.test_type_id=tt.id and tt.test_type_category_id = ttc.id GROUP BY ttc.name, mr.display, m.id, m.name");   
        }else{
            $alphanumeric_counts = DB::select("SELECT COUNT(DISTINCT e.id) as totalEncounters,COUNT(DISTINCT r.id) as totalResults, COUNT(DISTINCT t.id) as totalTests, m.name as measureName, m.id as measureId, mr.display FROM encounters e, tests t, results r, measures m, measure_ranges mr WHERE t.encounter_id = e.id and r.test_id=t.id and r.measure_id = m.id and m.measure_type_id = 2 and mr.display = r.result GROUP BY mr.display, m.id, m.name");
        }        
        return response()->json($alphanumeric_counts);
    } 
}
