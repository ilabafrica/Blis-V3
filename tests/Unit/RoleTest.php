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

class RoleTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
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
		$response=$this->post('/api/role',$this->roleData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display_name",$response->original);
	}

	public function testListRole()
	{
		$response=$this->get('/api/role');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowRole()
	{
		$response=$this->post('/api/role',$this->roleData);
		$response=$this->get('/api/role/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateRole()
	{
		$response=$this->post('/api/role',$this->roleData);
		$response=$this->put('/api/role/1',$this->updatedRoleData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("display_name",$response->original);
	}

	/*public function testDeleteRole()
	{
		$response=$this->post('/api/role',$this->roleData);
		$response=$this->delete('/api/role/4');
		$this->assertEquals(200,$response->getStatusCode());
	}*/

}