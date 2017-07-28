<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComponentTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->componentData=array(
        
			"observation_id"=>1,
			"performed_by"=>1,
			"result"=>'Sample String',
			"data_absent_reason"=>1,
			"interpretation"=>1,

        );
    	$this->updatedcomponentData=array(
        
			"observation_id"=>1,
			"performed_by"=>1,
			"result"=>'Sample updated String',
			"data_absent_reason"=>1,
			"interpretation"=>1,

        );
	}

	public function testStoreComponent()
	{
		$response=$this->json('POST', '/api/component',$this->componentData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("result",$response->original);
	}

	public function testListComponent()
	{
		$response=$this->json('GET', '/api/component');
		$response->assertStatus(200);
		
	}

	public function testShowComponent()
	{
		$this->json('POST', '/api/component',$this->componentData);
		$response=$this->json('GET', '/api/component/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("result",$response->original);
	}

	public function testUpdateComponent()
	{
		$this->json('POST', '/api/component',$this->componentData);
		$response=$this->json('PUT', '/api/component/1',$this->updatedcomponentData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("result",$response->original);
	}

	public function testDeleteComponent()
	{
		$this->json('POST', '/api/component',$this->componentData);
		$response=$this->delete('/api/component/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/component/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteComponentFail()
	{
		$response=$this->delete('/api/component/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}