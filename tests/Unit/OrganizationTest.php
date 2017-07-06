<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrganizationTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->organizationData=array(
        
			"user_id"=>1,
			"type"=>1,
			"name"=>'Sample String',
			"alias"=>'Sample String',
			"end_point"=>'Sample String',

        );
    	$this->updatedorganizationData=array(
        
			"user_id"=>1,
			"type"=>1,
			"name"=>'Sample updated String',
			"alias"=>'Sample updated String',
			"end_point"=>'Sample updated String',

        );
	}

	public function testStoreOrganization()
	{
		$response=$this->json('POST', '/api/organization',$this->organizationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testListOrganization()
	{
		$response=$this->json('GET', '/api/organization');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowOrganization()
	{
		$this->json('POST', '/api/organization',$this->organizationData);
		$response=$this->json('GET', '/api/organization/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateOrganization()
	{
		$this->json('POST', '/api/organization',$this->updatedorganizationData);
		$response=$this->json('PUT', '/api/organization');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteOrganization()
	{
		$this->json('POST', '/api/organization',$this->organizationData);
		$response=$this->delete('/api/organization/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}