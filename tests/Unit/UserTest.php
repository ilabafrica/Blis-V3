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

class UserTest extends TestCase
{
	use SetUp;
	use DatabaseMigrations;
	public function setVariables(){
		$this->userData=array(
			"name"=>'Sample String',
			"username"=>'Sample String',
			"email"=>'Sample String',
		);
		$this->updatedUserData=array(
			"name"=>'Sample updated String',
			"username"=>'Sample updated String',
			"email"=>'Sample updated String',
		);
	}

	public function testStoreUser()
	{
		$response=$this->post('/api/user',$this->userData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testListUser()
	{
		$response=$this->get('/api/user');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowUser()
	{
		$response=$this->post('/api/user',$this->userData);
		$response=$this->get('/api/user/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testUpdateUser()
	{
		$response=$this->post('/api/user',$this->userData);
		$response=$this->put('/api/user/1',$this->updatedUserData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testDeleteUser()
	{
		$response=$this->post('/api/user',$this->userData);
		$response=$this->delete('/api/user/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}