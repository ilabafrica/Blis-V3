<style type="text/css">
  table {
    padding: 2px;
  }
  td{font-family: Bookman Old Style; font-size: 10pt; font-variant: normal; font-style:normal;}
</style>
<table style="text-align:center;">
  <tr>
    <td colspan="12"></td>
  </tr>
  <tr>
    <td colspan="4" style="text-align:left;">
      <span style="font-size: 15px" ><b>{{$config->Facility_Name}}</b></span>
      <br>
      <br>             
      <span style="font-size: 10px" >{{$config->Facility_Name}}</span>
      <br>           
      <span style="font-size: 10px" >Student Centre</span>
      <br>
      <span style="font-size: 10px" >Email: {{$config->Email_Address}}</span>
    </td>
      <td colspan="4">
        <img src="profile_pictures/{{$config->Logo}}" height="80">        
      </td>
    <td  colspan="4" style="text-align:right;">
      <span style="font-size: 15px" ><b>{{$config->Facility_Name}}</b></span>
      <br>
      <br>
      <span style="font-size: 10px" >{{$config->Post_Address}}</span>
      <br>
      <span style="font-size: 10px" >{{$config->Facility_Name}}</span>
      <br>
      <span style="font-size: 10px" >{{$config->Facility_Name}}</span>
    </td>
  </tr>
  <tr>
    <td colspan="12">
      <span style="font-size: 12px;"><b>LABORATORY REPORT</b></span>
      <br>
      TEL: +256 393 108 951
    </td>
  </tr>
</table>
<table border="0" width="100%">
  <tr>
    <td width="20%"><b>Name :</b></td>
    <td width="30%">{{$patient->name->given}} {{$patient->name->family}}</td>
    <td width="20%"><b>Accession Date : </b></td>
    <td width="30%">{{date('Y-m-d',strtotime($patient->created_at))}}</td>
  </tr>
  <tr>
    <td><b>Gender & Age : </b></td>
    <td>{{$patient->birth_date}} | {{$patient->gender->display }}</td>
    <td><b>Report Date : </b></td>
    <td>{{date('Y-m-d')}}</td>
  </tr>
  <tr>
    <td><b>Patient No :</b></td>
    <td>{{$patient->identifier}}</td>
    <td><b>Location :</b></td>
    <td>{{$patient->encounters->last()->location->name}}</td>
  </tr>
</table>
<table style="border-bottom: 1px solid #cecfd5;">
  <tr>
    <th colspan="6">Lab Reception</th>
  </tr>
</table>
<table style="border-bottom: 1px solid #cecfd5;">
  <tr>
    <td colspan="2"><b>Specimen</b></td>
    <td colspan="2"><b>Received By</b></td>
    <td colspan="2"><b>Date</b></td>
    <td colspan="2"><b>Status</b></td>
    <td colspan="3"><b>Test Category</b></td>
    <td colspan="2"><b>Test Request</b></td>
  </tr>
</table>

<table style="border-bottom: 1px solid #cecfd5;">
  @forelse($patient->tests as $test)
    <!-- test has specimen -->



    @if($test->specimen)
    <!-- ?? how to deal with tests that have no specimen -->
    <tr>
      <td colspan="2">{{ $test->specimen->specimenType->name }}</td>
      @if($test->specimen->pending())
      <td colspan="2"></td>
      <td colspan="2"></td>
      <td colspan="2">Specimen Not Collected</td>
      @elseif($test->specimen->received())
      <td colspan="2">{{$test->specimen->receivedBy->name}}</td>
      <td colspan="2">{{$test->specimen->time_accepted}}</td>
      <td colspan="2">Received</td>
      @elseif($test->specimen->rejected())
      <td colspan="2">{{$test->specimen->rejectedBy->name}}</td>
      <td colspan="2">{{$test->specimen->time_rejected}}</td>
      <td colspan="2">Rejected</td>
      @endif
      <td colspan="3">{{ $test->testType->testTypeCategory->name }}</td>
      <td colspan="2">{{ $test->testType->name }}</td>
    </tr>
    @endif

<!-- xxx -->


  @empty
    <tr>
      <td colspan="6">No records found</td>
    </tr>
  @endforelse
</table>
<br>
<br>
<table  style="border-bottom: 1px solid #cecfd5;">
  <tr>
    <th colspan="6">Test Results</th>
  </tr>
</table>
<table  style="border-bottom: 1px solid #cecfd5;">
  <tr>
    <td colspan="2"><b>Test Types</b></td>
    <td colspan="8"><b>Test Results</b></td>
    <td colspan="2"><b>Tested by</b></td>
    <td colspan="2"><b>Results Entry Date</b></td>
  </tr>
</table>
<!-- ---------------------------- -->

@forelse($patient->tests as $test)
  @if(!$test->testType->isCulture() && ($test->isCompleted() || $test->isVerified()))
  <table  style="border-bottom: 1px solid #cecfd5;">
    <tr>
      <td colspan="2">{{ $test->testType->name }}</td>
      <td colspan="8">
  <table style="padding: 1px;">
    @foreach($test->results as $result)
      <!-- show only parameters with values -->
      @if($result->result != '')
      <tr>
        @if($test->testType->measures->count() > 1)
        <td>
          {{ $result->measure->name }}:
        </td>
        @endif
        <td>
          {{ $result->result }}
        </td>
        <td>
          <!-- {{ $result->getRange($patient,$result->measure_id) }} -->
        </td>
        <td>
          {{ $result->measure->unit }}
        </td>
      </tr>
      @endif
    @endforeach
  </table>
      </td>
        <td colspan="2">{{ $test->isCompleted()?$test->testedBy->name:'Pending'}}</td>
        <td colspan="2">{{ $test->time_completed }}</td>
    </tr>
  </table>
  @elseif($test->testType->isCulture())
    <!-- Culture and Sensitivity analysis -->
    @if(count($test->isolated_organisms)>0)<!-- if there are any isolated organisms -->
    <table style="border-bottom: 1px solid #cecfd5;">
      <tr>
        <td colspan="3"></td>
      </tr>
      <tr>
        <td colspan="3">Antimicrobial Susceptibility Testing(AST)</td>
      </tr>
      <tr>
        <th><b>Organism(s)</b></th>
        <th><b>Antibiotic(s)</b></th>
        <th><b>Result(s)</b></th>
      </tr>
    </table>
    @foreach($test->isolated_organisms as $isolated_organism)
    <table style="border-bottom: 1px solid #cecfd5;">
      <tr>
        <td rowspan="{{$isolated_organism->drug_susceptibilities->count()}}" class="organism">{{$isolated_organism->organism->name}}</td>
          <?php $i = 1; ?>
        @if($isolated_organism->drug_susceptibilities->count() == 0)
          </tr>
        @else
          @foreach($isolated_organism->drug_susceptibilities as $drug_susceptibility)
            @if ($i > 1)
            <tr>
            @endif
            <?php $i++; ?>
            <td class="antibiotic">{{$drug_susceptibility->drug->name}}</td>
            <td class="result">{{$drug_susceptibility->drug_susceptibility_measure->symbol}}</td>
          </tr>
          @endforeach
        @endif
    </table>
    @endforeach

    <table style="border-bottom: 1px solid #cecfd5;">
      <tr>
        <td>Comment(s)</td>
        <td colspan="2">
          {{$test->interpretation}}
        </td>
      </tr>
    </table>

    </hr>
    <table style="border-bottom: 1px solid #cecfd5;">
      <tr>
        <td><b>Analysis Performed by:</b></td>
        <td>{{ $test->isCompleted()?$test->testedBy->name:'Pending' }}</td>
        <!-- <td><b>Verified by:</b></td>
        <td>{{ $test->isVerified()?$test->verifiedBy->name:'Pending' }}</td> -->
      </tr>
    </table>
    <table style="border-bottom: 1px solid #cecfd5;">
      <tr>
         <td colspan="2">Result Guide</td>
         <td colspan="4" style="text-align:left;">S-Sensitive | R-Resistant | I-Intermediate</td>
      </tr>
    </table>
    @else<!-- if there are no isolated organisms -->
      @if($test->culture_observation)<!-- if there are comments -->
        <table>
          <tr>
            <td>{{ $test->culture_observation->observation }}</td>
          </tr>
        </table>
      @endif<!--./ if there are comments -->
    @endif<!--./ if there are no isolated organisms -->
  @endif
@empty
<table  style="border-bottom: 1px solid #cecfd5;">
  <tr>
    <td colspan="6">No Records Found</td>
  </tr>
</table>
@endforelse
<hr>
<table>
  <tr>
    <td>
    </td>
  </tr>
  <tr>
    <td>
      <strong>Approved By : </strong>
      _______________________________________
      <!-- THE APPROVED HERE -->
    </td>
  </tr>
</table>
