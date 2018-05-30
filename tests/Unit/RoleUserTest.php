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

class RoleUserTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->roleUserData=array(
			"user_id"=>1,
			"role_id"=>1,
		);
		$this->updatedRoleUserData=array(
			"user_id"=>1,
			"role_id"=>1,
		);
	}

	public function testStoreRoleUser()
	{
		$response=$this->post('/api/roleuser',$this->roleUserData);
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testListRoleUser()
	{
		$response=$this->get('/api/roleuser');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testDeleteRoleUser()
	{
		$response=$this->post('/api/roleuser',$this->roleUserData);
		$response=$this->post('/api/roleuser/delete',$this->roleUserData);
		$this->assertEquals(200,$response->getStatusCode());
	}

}