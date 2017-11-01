<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrganizationContactTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->organizationcontactData=array(
            "organization_id"=>1,
			"purpose"=>1,
			"name"=>1,
			"telecom"=>1,
			"address"=>1,


        );
    	$this->updatedorganizationcontactData=array(
            "organization_id"=>1,
			"purpose"=>1,
			"name"=>1,
			"telecom"=>1,
			"address"=>1,

        );
	}

	public function testStoreOrganizationContact()
	{
		$response=$this->json('POST', '/api/organizationcontact',$this->organizationcontactData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("purpose",$response->original);
	}

	public function testListOrganizationContact()
	{
		$response=$this->json('GET', '/api/organizationcontact');
		$response->assertStatus(200);
		
	}

	public function testShowOrganizationContact()
	{
		$this->json('POST', '/api/organizationcontact',$this->organizationcontactData);
		$response=$this->json('GET', '/api/organizationcontact/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateOrganizationContact()
	{
		$this->json('POST', '/api/organizationcontact',$this->organizationcontactData);
		$response=$this->json('PUT', '/api/organizationcontact/1',$this->updatedorganizationcontactData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteOrganizationContact()
	{
		$this->json('POST', '/api/organizationcontact',$this->organizationcontactData);
		$response=$this->delete('/api/organizationcontact/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/organizationcontact/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteOrganizationContactFail()
	{
		$response=$this->delete('/api/organizationcontact/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}