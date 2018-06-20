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

class PermissionRoleTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->permissionRoleData=array(
			"permission_id"=>1,
			"role_id"=>2,
		);
	}

	public function testAttachPermissionRole()
	{
		$response=$this->get('/api/permissionrole/detach?permission_id='.
			$this->permissionRoleData['permission_id'].'&&role_id='.
			$this->permissionRoleData['role_id']
		);
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testListPermissionRole()
	{
		$response=$this->get('/api/permissionrole');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testdetachPermissionRole()
	{
		$response=$this->get('/api/permissionrole/detach?permission_id='.
			$this->permissionRoleData['permission_id'].'&&role_id='.
			$this->permissionRoleData['role_id']
		);
		$this->assertEquals(200,$response->getStatusCode());
	}

}