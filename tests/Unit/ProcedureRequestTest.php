<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProcedureRequestTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->procedurerequestData=array(
        
			"definition_id"=>1,
			"based_on"=>'Sample String',
			"replaces"=>'Sample String',
			"requisition"=>1,
			"status"=>1,
			"intent"=>1,
			"priority"=>1,
			"do_not_perform"=>1,
			"category"=>1,
			"code"=>1,
			"subject"=>'Sample String',
			"context"=>1,
			"occurence"=>'2017:12:12 15:30:00',
			"asneeded"=>1,
			"authored_on"=>'2017:12:12 15:30:00',
			"requester"=>1,
			"performer_type"=>1,
			"performer"=>1,
			"reason_code"=>1,
			"reason_reference"=>'Sample String',
			"supporting_info"=>'Sample String',
			"specimen"=>1,
			"body_site"=>1,
			"note"=>'Sample String',
			"relevant_history"=>'Sample String',

        );
    	$this->updatedprocedurerequestData=array(
        
			"definition_id"=>1,
			"based_on"=>'Sample updated String',
			"replaces"=>'Sample updated String',
			"requisition"=>1,
			"status"=>1,
			"intent"=>1,
			"priority"=>1,
			"do_not_perform"=>1,
			"category"=>1,
			"code"=>1,
			"subject"=>'Sample updated String',
			"context"=>1,
			"occurence"=>'2017:12:12 16:30:00',
			"asneeded"=>1,
			"authored_on"=>'2017:12:12 16:30:00',
			"requester"=>1,
			"performer_type"=>1,
			"performer"=>1,
			"reason_code"=>1,
			"reason_reference"=>'Sample updated String',
			"supporting_info"=>'Sample updated String',
			"specimen"=>1,
			"body_site"=>1,
			"note"=>'Sample updated String',
			"relevant_history"=>'Sample updated String',

        );
	}

	public function testStoreProcedureRequest()
	{
		$response=$this->json('POST', '/api/procedurerequest',$this->procedurerequestData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListProcedureRequest()
	{
		$response=$this->json('GET', '/api/procedurerequest');
		$response->assertStatus(200);
		
	}

	public function testShowProcedureRequest()
	{
		$this->json('POST', '/api/procedurerequest',$this->procedurerequestData);
		$response=$this->json('GET', '/api/procedurerequest/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateProcedureRequest()
	{
		$this->json('POST', '/api/procedurerequest',$this->procedurerequestData);
		$response=$this->json('PUT', '/api/procedurerequest/1',$this->updatedprocedurerequestData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteProcedureRequest()
	{
		$this->json('POST', '/api/procedurerequest',$this->procedurerequestData);
		$response=$this->delete('/api/procedurerequest/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/procedurerequest/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteProcedureRequestFail()
	{
		$response=$this->delete('/api/procedurerequest/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}