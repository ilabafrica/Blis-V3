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

class PermissionTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->permissionData=array(
			"name"=>'Sample String',
			"display_name"=>'Sample String',
			"description"=>'Sample String',
		);
		$this->updatedPermissionData=array(
			"name"=>'Sample updated String',
			"display_name"=>'Sample updated String',
			"description"=>'Sample updated String',
		);
	}

	public function testStorePermission()
	{
		$response=$this->post('/api/permission',$this->permissionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListPermission()
	{
		$response=$this->get('/api/permission');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowPermission()
	{
		$response=$this->post('/api/permission',$this->permissionData);
		$response=$this->get('/api/permission/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdatePermission()
	{
		$response=$this->post('/api/permission',$this->permissionData);
		$response=$this->put('/api/permission/1',$this->updatedPermissionData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeletePermission()
	{
		$response=$this->post('/api/permission',$this->permissionData);
		$response=$this->delete('/api/permission/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}