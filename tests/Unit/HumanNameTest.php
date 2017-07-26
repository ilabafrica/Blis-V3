<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HumanNameTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->humannameData=array(
        
			"user_id"=>1,
			"use"=>1,
			"text"=>'Sample String',
			"family"=>'Sample String',
			"given"=>'Sample String',
			"prefix"=>'Sample String',
			"suffix"=>'Sample String',
			"period"=>'2017:12:12 15:30:00',
        );
    	$this->updatedhumannameData=array(
        
			"user_id"=>1,
			"use"=>1,
			"text"=>'Sample updated String',
			"family"=>'Sample updated String',
			"given"=>'Sample updated String',
			"prefix"=>'Sample updated String',
			"suffix"=>'Sample updated String',
			"period"=>'2016:12:12 15:30:00',
        );
	}

	public function testStoreHumanName()
	{
		$response=$this->json('POST', '/api/humanname',$this->humannameData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("user_id",$response->original);
	}

	public function testListHumanName()
	{
		$response=$this->json('GET', '/api/humanname');
		$response->assertStatus(200);
		
	}

	public function testShowHumanName()
	{
		$this->json('POST', '/api/humanname',$this->humannameData);
		$response=$this->json('GET', '/api/humanname/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testUpdateHumanName()
	{
		$this->json('POST', '/api/humanname',$this->humannameData);
		$response=$this->json('PUT', '/api/humanname/1',$this->updatedhumannameData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testDeleteHumanName()
	{
		$this->json('POST', '/api/humanname',$this->humannameData);
		$response=$this->delete('/api/humanname/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/humanname/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteHumanNameFail()
	{
		$response=$this->delete('/api/humanname/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}