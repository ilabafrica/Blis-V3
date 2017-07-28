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
        

			"created_by"=>1,
			"type"=>1,
			"active"=>1,
			"name"=>'Sample String',
			"alias"=>'Sample String',
			"telecom"=>1,
			"addres"=>123,
			"part_of"=>1,
			"end_point"=>'Sample String',

        );
    	$this->updatedorganizationData=array(
        
			"created_by"=>1,
			"active"=>1,
			"type"=>1,
			"name"=>'Sample Updated String',
			"alias"=>'Sample Updayed String',
			"telecom"=>1,
			"addres"=>1234,
			"part_of"=>1,
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
		$response = $this->json('PUT', '/api/organization/1', $this->updatedorganizationData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);

	}

	public function testDeleteOrganization()
	{
		$this->json('POST', '/api/organization',$this->organizationData);
		$response=$this->delete('/api/organization/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/organization/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteOrganizationFail()
	{
		$response=$this->delete('/api/organization/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}