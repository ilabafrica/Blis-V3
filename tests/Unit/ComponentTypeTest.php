<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComponentTypeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->componenttypeData=array(
        
			"code_id"=>1,
			"result_type_id"=>1,
			"reference_range_id"=>1,
			"parent_id"=>1,

        );
    	$this->updatedcomponenttypeData=array(
        
			"code_id"=>1,
			"result_type_id"=>1,
			"reference_range_id"=>1,
			"parent_id"=>1,

        );
	}

	public function testStoreComponentType()
	{
		$response=$this->json('POST', '/api/componenttype',$this->componenttypeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListComponentType()
	{
		$response=$this->json('GET', '/api/componenttype');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowComponentType()
	{
		$this->json('POST', '/api/componenttype',$this->componenttypeData);
		$response=$this->json('GET', '/api/componenttype/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateComponentType()
	{
		$this->json('POST', '/api/componenttype',$this->updatedcomponenttypeData);
		$response=$this->json('PUT', '/api/componenttype');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteComponentType()
	{
		$this->json('POST', '/api/componenttype',$this->componenttypeData);
		$response=$this->delete('/api/componenttype/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}