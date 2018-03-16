<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\SetUp;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrganizationTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->organizationData=array(
			"identifier"=>'Sample String',
			"created_by"=>1,
			"active"=>'Sample String',
			"organization_type_id"=>1,
			"name"=>'Sample String',
			"alias"=>'Sample String',
			"telecom"=>'Sample String',
			"address"=>'Sample String',
		);
		$this->updatedOrganizationData=array(
			"identifier"=>'Sample updated String',
			"created_by"=>1,
			"active"=>'Sample updated String',
			"organization_type_id"=>1,
			"name"=>'Sample updated String',
			"alias"=>'Sample updated String',
			"telecom"=>'Sample updated String',
			"address"=>'Sample updated String',
		);
	}

	public function testStoreOrganization()
	{
		$response=$this->post('/api/organization',$this->organizationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("address",$response->original);
	}

	public function testListOrganization()
	{
		$response=$this->get('/api/organization');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowOrganization()
	{
		$response=$this->post('/api/organization',$this->organizationData);
		$response=$this->get('/api/organization/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("address",$response->original);
	}

	public function testUpdateOrganization()
	{
		$response=$this->post('/api/organization',$this->organizationData);
		$response=$this->put('/api/organization/1',$this->updatedOrganizationData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("address",$response->original);
	}

	public function testDeleteOrganization()
	{
		$response=$this->post('/api/organization',$this->organizationData);
		$response=$this->delete('/api/organization/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}