<?php
namespace Tests\Unit;
/**
 * (c) @iLabAfrica
 * BLIS			 - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead	 - Emmanuel Kweyu.
 * Devs			 - Brian Maiyo|Ann Chemutai|Winnie Mbaka|Ken Mutuma|Anthony Ereng
 */

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoleTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->roleData=array(
			"name"=>'Sample String',
			"display_name"=>'Sample String',
			"description"=>'Sample String',
		);
		$this->updatedRoleData=array(
			"name"=>'Sample updated String',
			"display_name"=>'Sample updated String',
			"description"=>'Sample updated String',
		);
	}

	public function testStoreRole()
	{
		$response=$this->json('POST', '/api/role',$this->roleData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListRole()
	{
		$response=$this->json('GET', '/api/role');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowRole()
	{
		$this->json('POST', '/api/role',$this->roleData);
		$response=$this->json('GET', '/api/role/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateRole()
	{
		$this->json('POST', '/api/role',$this->roleData);
		$response=$this->json('PUT', '/api/role/1',$this->updatedRoleData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteRole()
	{
		$this->json('POST', '/api/role',$this->roleData);
		$response=$this->delete('/api/role/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}