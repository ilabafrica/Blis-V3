<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReferenceRangeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->referencerangeData=array(
            
            "low_normal"=>1,
            "high_normal"=>2,
            "low_critical"=>1,
            "high_critical"=>2,
            "age_min"=>3,
            "age_max"=>5,
			"age_type"=>1,
			"applies_to"=>1,
			"text"=>'Sample String',

        );
    	$this->updatedreferencerangeData=array(
        
			"low_normal"=>1,
            "high_normal"=>2,
            "low_critical"=>1,
            "high_critical"=>2,
            "age_min"=>3,
            "age_max"=>5,
			"age_type"=>1,
			"applies_to"=>1,
			"text"=>'Sample updated String',

        );
	}

	public function testStoreReferenceRange()
	{
		$response=$this->json('POST', '/api/referencerange',$this->referencerangeData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testListReferenceRange()
	{
		$response=$this->json('GET', '/api/referencerange');
		$response->assertStatus(200);
		
	}

	public function testShowReferenceRange()
	{
		$this->json('POST', '/api/referencerange',$this->referencerangeData);
		$response=$this->json('GET', '/api/referencerange/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testUpdateReferenceRange()
	{
		$this->json('POST', '/api/referencerange',$this->referencerangeData);
		$response=$this->json('PUT', '/api/referencerange/1',$this->updatedreferencerangeData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("text",$response->original);
	}

	public function testDeleteReferenceRange()
	{
		$this->json('POST', '/api/referencerange',$this->referencerangeData);
		$response=$this->delete('/api/referencerange/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/referencerange/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteReferenceRangeFail()
	{
		$response=$this->delete('/api/referencerange/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}