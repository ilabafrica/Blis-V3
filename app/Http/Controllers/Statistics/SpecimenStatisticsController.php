<?php

namespace App\Http\Controllers\Statistics;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SpecimenStatisticsController extends Controller
{
    // get the basic information on specimen statuses
    public function specimenStatuses()
    {
        $specimen_statuses = DB::select('SELECT id, name FROM specimen_statuses');

        return response()->json($specimen_statuses);
    }

    // get the basic information on specimen types
    public function specimenTypes()
    {
        $specimen_types = DB::select('SELECT id, name FROM specimen_types');

        return response()->json($specimen_types);
    }

    // get the total number of specimen grouped Query
    public function specimenTotals(Request $request)
    {
        $selects = 'COUNT(*) as total';
        $tables = 'specimens s';
        $wheres = '1';
        $group_bys = '';
        // By Users
        if ($request->query('received_by')) { // grouped by particular user
            $selects = $selects.', s.received_by';
            $wheres = $wheres.' AND s.received_by='.$request->query('received_by');
            $group_bys = $group_bys.', s.received_by';
        } elseif ($request->query('by_receiver')) { // grouped by users
            $selects = $selects.', s.received_by';
            $group_bys = $group_bys.', s.received_by';
        }
        // By Status
        if ($request->query('specimen_status')) { // grouped by particular status
            $selects = $selects.', s.specimen_status_id';
            $wheres = $wheres.' AND s.specimen_status_id='.$request->query('specimen_status');
            $group_bys = $group_bys.', s.specimen_status_id';
        } elseif ($request->query('by_status')) { // grouped by status
            $selects = $selects.', s.specimen_status_id';
            $group_bys = $group_bys.', s.specimen_status_id';
        }
        // By Type
        if ($request->query('specimen_type')) { // grouped by type
            $selects = $selects.', s.specimen_type_id';
            $wheres = $wheres.' AND s.specimen_type_id='.$request->query('specimen_type');
            $group_bys = $group_bys.', s.specimen_type_id';
        } elseif ($request->query('by_type')) { // grouped by type
            $selects = $selects.', s.specimen_type_id';
            $group_bys = $group_bys.', s.specimen_type_id';
        }
        // By Date Collected
        if ($request->query('collected_before_date') || $request->query('collected_at_date') || $request->query('collected_after_date')) { // group by particular date(s)
            if ($request->query('collected_at_date') && $this->checkmydate($request->query('collected_at_date'))) { //group by particular date
                $selects = $selects.', DATE(s.time_collected) as date_collected';
                $wheres = $wheres." AND DATE(s.time_collected)='".$request->query('collected_at_date')."'";
                $group_bys = $group_bys.', date_collected';
            } else {
                if ($request->query('collected_before_date') && $this->checkmydate($request->query('collected_before_date')) && $request->query('collected_after_date') && $this->checkmydate($request->query('collected_after_date'))) {
                    $selects = $selects.', DATE(s.time_collected) as date_collected';
                    $wheres = $wheres." AND DATE(s.time_collected)<'".$request->query('collected_before_date')."' AND DATE(s.time_collected)>'".$request->query('collected_after_date')."'";
                    $group_bys = $group_bys.', date_collected';
                } else {
                    if ($request->query('collected_before_date') && $this->checkmydate($request->query('collected_before_date'))) {
                        $selects = $selects.', DATE(s.time_collected) as date_collected';
                        $wheres = $wheres." AND DATE(s.time_collected)<'".$request->query('collected_before_date')."'";
                        $group_bys = $group_bys.', date_collected';
                    } elseif ($request->query('collected_after_date') && $this->checkmydate($request->query('collected_after_date'))) {
                        $selects = $selects.', DATE(s.time_collected) as date_collected';
                        $wheres = $wheres." AND DATE(s.time_collected)>'".$request->query('collected_after_date')."'";
                        $group_bys = $group_bys.', date_collected';
                    }
                }
            }
        } elseif ($request->query('by_date_collected')) { // grouped by date collected
            $selects = $selects.', DATE(s.time_collected) as date_collected';
            $group_bys = $group_bys.', date_collected';
        }
        // By Date Received
        if ($request->query('received_before_date') || $request->query('received_at_date') || $request->query('received_after_date')) { // group by particular date(s)
            if ($request->query('received_at_date') && $this->checkmydate($request->query('received_at_date'))) { //group by particular date
                $selects = $selects.', DATE(s.time_received) as specimen_received_at';
                $wheres = $wheres." AND DATE(s.time_received)='".$request->query('received_at_date')."'";
                $group_bys = $group_bys.', specimen_received_at';
            } else {
                if ($request->query('before_date') && $this->checkmydate($request->query('received_before_date')) && $request->query('received_after_date') && $this->checkmydate($request->query('received_after_date'))) {
                    $selects = $selects.', DATE(s.time_received) as specimen_received_at';
                    $wheres = $wheres." AND DATE(s.time_received)<'".$request->query('received_before_date')."' AND DATE(s.time_received)>'".$request->query('received_after_date')."'";
                    $group_bys = $group_bys.', specimen_received_at';
                } else {
                    if ($request->query('received_before_date') && $this->checkmydate($request->query('received_before_date'))) {
                        $selects = $selects.', DATE(s.time_received) as specimen_received_at';
                        $wheres = $wheres." AND DATE(s.time_received)<'".$request->query('received_before_date')."'";
                        $group_bys = $group_bys.', specimen_received_at';
                    } elseif ($request->query('received_after_date') && $this->checkmydate($request->query('received_after_date'))) {
                        $selects = $selects.', DATE(s.time_received) as specimen_received_at';
                        $wheres = $wheres." AND DATE(s.time_received)>'".$request->query('received_after_date')."'";
                        $group_bys = $group_bys.', specimen_received_at';
                    }
                }
            }
        } elseif ($request->query('by_date_received')) { // grouped by date received
            $selects = $selects.', DATE(s.time_received) as specimen_received_at';
            $group_bys = $group_bys.', specimen_received_at';
        }

        if ($request->query('with_ids')) {
            $selects = $selects.', GROUP_CONCAT(s.id) as ids';
        }
        // return response()->json("SELECT ".$selects." FROM ".$tables." WHERE ".$wheres);
        if ($group_bys) { // is there anything to group by? if yes then
            $specimen = DB::select('SELECT '.$selects.' FROM '.$tables.' WHERE '.$wheres.' GROUP BY '.substr($group_bys, 1));
        } else {
            $specimen = DB::select('SELECT '.$selects.' FROM '.$tables.' WHERE '.$wheres);
        }

        return response()->json($specimen);
    }

    public function checkmydate($date)
    { // date passed in yyyy-mm-dd or yyyy/mm/dd format
        $tempDate = explode('-', $date); // try date format seperated by - i.e. yyyy-mm-dd
        // checkdate(month, day, year)
        if (count($tempDate) != 3) {
            $tempDate = explode('/', $date); // try format seperated by / i.e.  yyyy/mm/dd
            if (count($tempDate) != 3) {
                return false;
            }
        }

        return checkdate($tempDate[1], $tempDate[2], $tempDate[0]);
    }
}
