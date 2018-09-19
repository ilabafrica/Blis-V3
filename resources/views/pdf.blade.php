<table border="0" width="100%" cellpadding="5" style="" >
    <tr>
        <td width="50%">
            <b>Patient Name:</b> {{$patient->name->family}}, {{$patient->name->given}}<br>
            <b>Gender:</b> {{$patient->gender->display}}<br>
            <b>Date Of Birth:</b> {{$patient->birth_date}}
        </td>
        <td width="50%" style="text-align:right;">
            <b>Patient Report</b><br>
            Facility Name<br>            
            Date: {{date("Y/m/d")}}
        </td>
    </tr>
</table>

@if(count($patient->tests)!=0)
    @foreach($patient->tests as $key => $test)        
        <hr />
        <h3 style="color:#555">Test Number: {{$test->id}} </h3>
        <b>Test Type:</b> {{$test->testType->name}}<br/>
        <b>Test Ordered At:</b> {{$test->created_at}}<br/>
        <b>Test Status:</b> {{$test->testStatus->name}}<br/><br/>
            @if($test->specimen)
                <table border="1" width="100%" cellpadding="10"  style="margin-left:20px;">
                    <tr style="background-color:#1e1e1e; color:white; padding:15px;">
                        <th width="20%">Specimen Type</th>
                        <th width="20%">Collected By</th>
                        <th width="20%">Date Collected</th>
                        <th width="20%">Date Received</th>
                        <th width="20%">Status</th>
                    </tr>
                    <tr style="font-size:10px;">
                        <td>{{$test->specimen->specimenType->name}}</td>
                        <td>{{$test->specimen->collectedBy->name}}</td>
                        <td>{{$test->specimen->time_collected}}</td>
                        <td>{{$test->specimen->time_received}}</td>
                        <td>{{$test->specimen->status->name}}</td>
                    </tr>
                </table>
            @endif
            <br />
            <br />
            @if(count($test->results)!=0)
                <table border="1" width="100%" cellpadding="10">
                    <tr style="background-color:#1e1e1e; color:white; padding:15px;">
                        <th width="25%">Result ID</th>
                        <th width="25%">Measure</th>
                        <th width="25%">Result</th>
                        <th width="25%">Date Entered</th>
                    </tr>
                    @foreach($test->results as $result)
                        <tr  style="font-size:10px;">
                            <td>{{$result->id}}</td>
                            <td>{{$result->measure->name}}</td>
                            <td>{{$result->result}}</td>
                            <td>{{$result->time_entered}}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h5>No Results Entered</h5>
            @endif
            <br />
            <br />
    @endforeach
@else 
    <h1>No Tests Found</h1>
@endif