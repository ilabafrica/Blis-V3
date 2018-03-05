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

class UserTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
		$this->userData=array(
			"name"=>'Sample String',
			"username"=>'Sample String',
			"email"=>'Sample String',
			"password"=>'Sample String',
			"remember_token"=>'Sample String',
		);
		$this->updatedUserData=array(
			"name"=>'Sample updated String',
			"username"=>'Sample updated String',
			"email"=>'Sample updated String',
			"password"=>'Sample updated String',
			"remember_token"=>'Sample updated String',
		);
	}

	public function testStoreUser()
	{
		$response=$this->json('POST', '/api/user',$this->userData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("remember_token",$response->original);
	}

	public function testListUser()
	{
		$response=$this->json('GET', '/api/user');
		$this->assertEquals(200,$response->getStatusCode());
	}

	public function testShowUser()
	{
		$this->json('POST', '/api/user',$this->userData);
		$response=$this->json('GET', '/api/user/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("remember_token",$response->original);
	}

	public function testUpdateUser()
	{
		$this->json('POST', '/api/user',$this->userData);
		$response=$this->json('PUT', '/api/user/1',$this->updatedUserData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("remember_token",$response->original);
	}

	public function testDeleteUser()
	{
		$this->json('POST', '/api/user',$this->userData);
		$response=$this->delete('/api/user/1');
		$this->assertEquals(200,$response->getStatusCode());
	}

}