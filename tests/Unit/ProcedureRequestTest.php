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
			"status"=>1,
			"intent"=>1,
			"priority"=>1,
			"category"=>1,
			"code"=>1,
			"subject"=>'Sample String',
			"context"=>1,
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
			"status"=>1,
			"intent"=>1,
			"priority"=>1,
			"category"=>1,
			"code"=>1,
			"subject"=>'Sample updated String',
			"context"=>1,
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
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListProcedureRequest()
	{
		$response=$this->json('GET', '/api/procedurerequest');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowProcedureRequest()
	{
		$this->json('POST', '/api/procedurerequest',$this->procedurerequestData);
		$response=$this->json('GET', '/api/procedurerequest/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testUpdateProcedureRequest()
	{
		$this->json('POST', '/api/procedurerequest',$this->updatedprocedurerequestData);
		$response=$this->json('PUT', '/api/procedurerequest');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testDeleteProcedureRequest()
	{
		$this->json('POST', '/api/procedurerequest',$this->procedurerequestData);
		$response=$this->delete('/api/procedurerequest/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}