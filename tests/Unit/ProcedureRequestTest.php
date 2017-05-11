<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProcedureRequestTest extends TestCase
{
   public function testStoreProcedureRequest(){

    	$procedurerequest=array(
    		'based_on'=>"sample x",
    		'replaces'=>"sample y",
    		'requisition'=>20,
    		'status'=>1,
    		'intent'=>1,
    		'priority'=>1,
    		'do_not_perform'=>false,
    		'code'=>1,
    		'subject'=>"DerrickRono",
    		'context'=>1,
    		'occurence'=>"2015-12-12 12:00:00",
    		'asneeded'=>1,
    		'requester'=>1,
    		'performer_type'=>1,
    		'performer'=>1,
    		'reason_code'=>1,
    		'reason_reference'=>"no reason",
    		'supporting_info'=>"n/a",
    		'specimen'=>1,
    		'body_site'=>1,
    		'note'=>"n/a",
    		'relevant_history'=>"n/a",
    		);
    	$response=$this->post('/api/procedure_request',$procedurerequest);

    	$this->assertEquals(200,$response->getStatusCode());
    }

    public function testListProcedureRequests(){

    	$response=$this->get('/api/procedure_request');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertArrayHasKey('performer', $data);
    }

    public function testListProcedureRequest(){

    	$response=$this->get('/api/procedure_request/1');
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('performer', $data);
    }

    public function testUpdateProcedureRequest(){

    	$procedurerequest=array(
    		'based_on'=>"sample x",
    		'performer_type'=>1,
    		'performer'=>1,
    		'reason_code'=>1,
    		'reason_reference'=>"many reason",
    		'supporting_info'=>"n/a",
    		'specimen'=>1,
    		'body_site'=>1,
    		'note'=>"n/a",
    		'relevant_history'=>"n/a",
    		);
    	$response=$this->put('/api/procedure_request/1',$procedurerequest);
    	$this->assertEquals(200,$response->getStatusCode());
    	//data
    	$data=json_decode($response->getBody());

    	$this->assertHasKey('id', $data);
    }

    public function testDeleteProcedureRequest(){
    	
    	$response=$this->delete('/api/procedure_request/1');
    	$this->assertEquals(200,$response->getStatusCode());
    }
