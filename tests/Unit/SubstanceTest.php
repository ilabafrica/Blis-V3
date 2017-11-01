<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SubstanceTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->substanceData=array(
        
			"status"=>1,
			"category"=>1,
			"code"=>1,
			"description"=>'Sample String',

        );
    	$this->updatedsubstanceData=array(
        
			"status"=>1,
			"category"=>1,
			"code"=>1,
			"description"=>'Sample updated String',

        );
	}

	public function testStoreSubstance()
	{
		$response=$this->json('POST', '/api/substance',$this->substanceData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListSubstance()
	{
		$response=$this->json('GET', '/api/substance');
		$response->assertStatus(200);
		
	}

	public function testShowSubstance()
	{
		$this->json('POST', '/api/substance',$this->substanceData);
		$response=$this->json('GET', '/api/substance/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateSubstance()
	{
		$this->json('POST', '/api/substance',$this->substanceData);
		$response=$this->json('PUT', '/api/substance/1',$this->updatedsubstanceData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteSubstance()
	{
		$this->json('POST', '/api/substance',$this->substanceData);
		$response=$this->delete('/api/substance/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/substance/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteSubstanceFail()
	{
		$response=$this->delete('/api/substance/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}