<?php
namespace Tests\Unit;

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
        
			"email"=>'Sample String',
			"password"=>'Sample String',

        );
    	$this->updateduserData=array(
        
			"email"=>'Sample updated String',
			"password"=>'Sample updated String',

        );
	}

	public function testStoreUser()
	{
		$response=$this->json('POST', '/api/user',$this->userData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testListUser()
	{
		$response=$this->json('GET', '/api/user');
		$response->assertStatus(200);
		
	}

	public function testShowUser()
	{
		$this->json('POST', '/api/user',$this->userData);
		$response=$this->json('GET', '/api/user/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testUpdateUser()
	{
		$this->json('POST', '/api/user',$this->userData);
		$response=$this->json('PUT', '/api/user/1',$this->updateduserData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testDeleteUser()
	{
		$this->json('POST', '/api/user',$this->userData);
		$response=$this->delete('/api/user/1');
		$response->assertStatus(200);
		
	}

}