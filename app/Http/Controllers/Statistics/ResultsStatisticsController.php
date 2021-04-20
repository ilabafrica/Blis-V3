<?php

namespace App\Http\Controllers\Statistics;

use App\Models\Test;
use App\Models\Result;
use App\Models\Patient;
use App\Models\AdhocConfig;
use Illuminate\Http\Request;
use App\Models\PatientReportPDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResultsStatisticsController extends Controller
{
    public function patientHistory(Request $request)
    {

// patient id is a must here
        if ($request->query('test_id')) {

            $patientReportData['tests'] = Test::with(
                'encounter.patient'
                'results.measure.measureRanges',
                'testType',
                'specimen.status',
                'specimen.specimenType',
                'specimen.collectedBy',
                'specimen.receivedBy',
            )->where('id',$request->query('test_id'))->get();
            $patientReportData['encounters'] = [$test->encounter];
            $patientReportData['patient'] = $test->encounter->patient;
        }elseif ($request->query('encounter_id')) {

        }elseif ($request->query('patient_id')) {
            $patient = Patient::with([
                'name',
                'gender',
                'encounters',
                'tests.results.measure.measureRanges',
                'tests.testType',
                'tests.specimen.status',
                'tests.specimen.specimenType',
                'tests.specimen.collectedBy',
                'tests.specimen.receivedBy',
                'tests.encounter',
                'tests.testStatus'
            ])->find($request->query('patient_id'));
            $patientReportData['tests'] = $patient->tests;


// dd($patientReportData);
// dd($patient);

// $patientReportData = [];
$patientReportData['encounters'] = $patient->encounters;
$patientReportData['encounters'] = Encounter::with('patient')->where('id',$request->query('encounter_id'))->get();

$patientReportData['tests'] = $patient->tests;
$patientReportData['tests'] = Encounter::find($request->query('encounter_id'))->tests;
$patientReportData['patient'] = $patient;
$patientReportData['patient'] = $encounter->patient;
/*

arrange results in a standard way alll the way what I need

$encounters
$encounter

$tests
$test

$patient


test_id =113
encounter_id =113
$request->query('encounter_id')
$request->query('test_id')
$request->query('patient_id')

<!-- 
-------- BLIS
@if(app('request')->input('encounter_id'))
@endif
@if(app('request')->input('test_id'))
@endif
    app('request')->input('encounter_id')
    app('request')->input('test_id')
encounter_id
test_id

$request->query('encounter_id')
$request->query('test_id')
$request->query('patient_id')


reports_patient
ResultsStatisticsController

http://blis-v3.test/api/stats/results/patient?pdf=true&id=15

reports index, remove cards put table, get from control index
reports patient page doesnt load, it broken, unbreak it

release

print specimen tracker ... the barcode in thespecimen tracker manenoz
consolidate every package

create video user manual (microphone from jerry) - BLIS Playlist
--------Riverside
riverside website attach people

 -->

*/

            if ($request->query('pdf') ) {
                $pdf = new PatientReportPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $config = AdhocConfig::getConfigs();
                $view = \View::make('pdf', compact('patient','config'));
                $html_content = $view->render();
                $pdf->AddPage();
                $pdf->writeHTML($html_content, true, false, true, false, '');
                // return $pdf->Output('report.pdf', 'I');
                return $view;

            } else {
                return $patient;
            }
        }
    }

    // get the alphanumeric counts
    public function alphanumericCounts(Request $request)
    {
        $selects = 'COUNT(DISTINCT r.id) as total';
        $tables = 'results r';
        $wheres = '1';
        $group_bys = '';
        // By Measure
        if ($request->query('measure_id')) { // grouped by particular measure
            $selects = $selects.', r.measure_id';
            $wheres = $wheres.' AND r.measure_id='.$request->query('measure_id');
            $group_bys = $group_bys.', r.measure_id';
        } elseif ($request->query('by_measures')) { // grouped by measures
            $selects = $selects.', r.measure_id';
            $group_bys = $group_bys.', r.measure_id';
        }
        // Adding the measures and measure types table
        if ($request->query('measure_type_id') || $request->query('by_measure_types') || $request->query('by_results')) { // grouped by particular measure
            $tables = $tables.', measures m';
            $wheres = $wheres.' AND r.measure_id = m.id';
            if ($request->query('measure_type_id') || $request->query('by_measure_types') || $request->query('by_results')) { // grouped by particular measure
                $tables = $tables.', measure_types mt';
                $wheres = $wheres.' AND m.measure_type_id = mt.id';
            }
        }
        // By Measure Type
        if ($request->query('measure_type_id')) { // grouped by particular measure
            $selects = $selects.', m.measure_type_id';
            $wheres = $wheres.' AND m.measure_type_id='.$request->query('measure_type_id');
            $group_bys = $group_bys.', m.measure_type_id';
        } elseif ($request->query('by_measure_types')) { // grouped by measures
            $selects = $selects.', m.measure_type_id';
            $group_bys = $group_bys.', m.measure_type_id';
        }
        // By Test Type
        if ($request->query('test_type_id')) { // grouped by particular test type
            $selects = $selects.', t.test_type_id';
            $wheres = $wheres.' AND t.test_type_id='.$request->query('test_type_id');
            $group_bys = $group_bys.', t.test_type_id';
        } elseif ($request->query('by_test_types')) { // grouped by test types
            $selects = $selects.', t.test_type_id';
            $group_bys = $group_bys.', t.test_type_id';
        }
        // Adding the tests and test types tables
        if ($request->query('test_type_id') || $request->query('by_test_types') || $request->query('by_results') || $request->query('by_age') || $request->query('age_group') || $request->query('gender_id') || $request->query('by_gender')) { // grouped by particular test type
            $tables = $tables.', tests t, test_types tt';
            $wheres = $wheres.' AND r.test_id = t.id AND t.test_type_id = tt.id';
            if ($request->query('by_age') || $request->query('gender_id') || $request->query('by_gender')) {
                $tables = $tables.', patients p, encounters e';
                $wheres = $wheres.' AND t.encounter_id = e.id AND e.patient_id=p.id';
            }
        }
        // By Results
        if ($request->query('by_results')) { // grouped by results, only alphanumeric
            if ($request->query('by_results') == 'alpha') {
                $selects = $selects.', COUNT(DISTINCT r.id) as total_results, COUNT(DISTINCT t.id) as total_tests, m.name as measure_name, m.id as measure_id, mr.display as measure_range_display, mr.id as measure_range_id';
                $tables = $tables.', measure_ranges mr';
                // $wheres = $wheres . " AND r.result = mr.display AND mt.id = 2";
                $wheres = $wheres.' AND r.measure_range_id = mr.id AND mt.id = 2';
                $group_bys = $group_bys.', m.name, m.id, mr.display, mr.id';
            } elseif ($request->query('by_results') == 'nume') {
                $selects = $selects.', COUNT(DISTINCT r.id) as total_results, COUNT(DISTINCT t.id) as total_tests, m.name as measure_name, m.id as measure_id, mr.id as measure_range_id, mr.low, mr.high, r.result';
                $tables = $tables.', patients p, encounters e, measure_ranges mr';
                $wheres = $wheres.' AND mt.id=1 AND t.encounter_id=e.id AND mr.measure_id=r.measure_id AND e.patient_id=p.id AND mr.gender_id IN (p.gender_id,3) AND r.result BETWEEN mr.low AND mr.high AND DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 BETWEEN mr.age_min AND mr.age_max';
                $group_bys = $group_bys.', m.name, m.id, mr.id, mr.low, mr.high, r.result';
            }
        }
        // By Patient age
        if ($request->query('by_age')) { // grouped by patient ages
            $selects = $selects.",  SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 <= 5,1,0)) as 'under_5', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 BETWEEN 5 and 20,1,0)) as '5_to_20', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25>=20,1,0)) as 'over_20'";
            $wheres = $wheres.' AND t.test_status_id>2'; //the test needs to have been started in order to get the age of patient at test status. This may be changed later to reflect specimen collection date
        } elseif ($request->query('age_group')) { // grouped by patient ages
            $ages = explode(',', $request->query('age_group'));
            if (count($ages) == 2 && is_numeric($ages[0]) && is_numeric($ages[1])) {
                $ages[0] = intval($ages[0]);
                $ages[1] = intval($ages[1]);
                $selects = $selects.',  SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 <='.$ages[0].",1,0)) as 'under_".$ages[0]."', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25 BETWEEN ".$ages[0].' and '.$ages[1].",1,0)) as '".$ages[0].'_to_'.$ages[1]."', SUM(IF(DATEDIFF(DATE(t.time_started), p.birth_date)/365.25>=".$ages[1].",1,0)) as 'over_".$ages[1]."'";
                $wheres = $wheres.' AND t.test_status_id>2'; //the test needs to have been started in order to get the age of patient at test status. This may be changed later to reflect specimen collection date
            }
        }
        // By Gender
        if ($request->query('gender_id')) { // grouped by particular gender
            $selects = $selects.', p.gender_id';
            $wheres = $wheres.' AND p.gender_id='.$request->query('gender_id');
            $group_bys = $group_bys.', p.gender_id';
        } elseif ($request->query('by_gender')) { // grouped by gender
            $selects = $selects.', p.gender_id';
            $group_bys = $group_bys.', p.gender_id';
        }
        // By Date entered
        if ($request->query('entered_before_date') || $request->query('entered_at_date') || $request->query('entered_after_date')) { // group by particular date(s)
            if ($request->query('entered_at_date') && $this->checkmydate($request->query('entered_at_date'))) { //group by particular date
                $selects = $selects.', DATE(r.time_entered) as result_entered_at';
                $wheres = $wheres." AND DATE(r.time_entered)='".$request->query('entered_at_date')."'";
                $group_bys = $group_bys.', result_entered_at';
            } else {
                if ($request->query('entered_before_date') && $this->checkmydate($request->query('entered_before_date')) && $request->query('entered_after_date') && $this->checkmydate($request->query('entered_after_date'))) {
                    $selects = $selects.', DATE(r.time_entered) as result_entered_at';
                    $wheres = $wheres." AND DATE(r.time_entered)<'".$request->query('entered_before_date')."' AND DATE(r.time_entered)>'".$request->query('entered_after_date')."'";
                    $group_bys = $group_bys.', result_entered_at';
                } else {
                    if ($request->query('entered_before_date') && $this->checkmydate($request->query('entered_before_date'))) {
                        $selects = $selects.', DATE(r.time_entered) as result_entered_at';
                        $wheres = $wheres." AND DATE(r.time_entered)<'".$request->query('entered_before_date')."'";
                        $group_bys = $group_bys.', result_entered_at';
                    } elseif ($request->query('entered_after_date') && $this->checkmydate($request->query('entered_after_date'))) {
                        $selects = $selects.', DATE(r.time_entered) as result_entered_at';
                        $wheres = $wheres." AND DATE(r.time_entered)>'".$request->query('entered_after_date')."'";
                        $group_bys = $group_bys.', result_entered_at';
                    }
                }
            }
        } elseif ($request->query('by_date_entered')) { // grouped by date entered
            $selects = $selects.', DATE(r.time_entered) as result_entered_at';
            $group_bys = $group_bys.', result_entered_at';
        }
        // encounters e, tests t, results r, measures m, measure_ranges mr, test_types tt, test_type_categories ttc
        //  WHERE t.encounter_id = e.id and r.test_id=t.id and r.measure_id = m.id and m.measure_type_id = 2 and mr.display = r.result and t.test_type_id=tt.id and tt.test_type_category_id = ttc.id
        if ($request->query('with_ids')) {
            $selects = $selects.', GROUP_CONCAT(t.id) as ids';
        }
        if ($request->query('full_values')) {
            $results = DB::table(DB::raw($tables))->select(DB::raw('r.*'))->whereRaw($wheres)->paginate(10);
        } else {
            // return response()->json("SELECT ".$selects." FROM ".$tables." WHERE ".$wheres." GROUP BY ".substr($group_bys, 1));
            if ($group_bys) { // is there anything to group by? if yes then
                $results = DB::select('SELECT '.$selects.' FROM '.$tables.' WHERE '.$wheres.' GROUP BY '.substr($group_bys, 1));
            } else {
                $results = DB::select('SELECT '.$selects.' FROM '.$tables.' WHERE '.$wheres);
            }
        }

        return response()->json($results);
    }
}
