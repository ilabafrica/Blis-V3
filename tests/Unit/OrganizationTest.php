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
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListOrganization()
	{
		$response=$this->json('GET', '/api/organization');
		$response->assertStatus(200);
		
	}

	public function testShowOrganization()
	{
		$this->json('POST', '/api/organization',$this->organizationData);
		$response=$this->json('GET', '/api/organization/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateOrganization()
	{
		$this->json('POST', '/api/organization',$this->organizationData);
		$response=$this->json('PUT', '/api/organization/1',$this->updatedorganizationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteOrganization()
	{
		$this->json('POST', '/api/organization',$this->organizationData);
		$response=$this->delete('/api/organization/1');
		$response->assertStatus(200);
		
	}

}