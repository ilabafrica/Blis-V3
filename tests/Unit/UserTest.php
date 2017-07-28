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
            
            "type"=>1, 
			"email"=>'Sample String',
			"password"=>'Sample String',
			"token"=>"12233",

        );
    	$this->updateduserData=array(
            
            "type"=>1,
			"email"=>'Sample updated String',
			"password"=>'Sample updated String',
			"token"=>"1223345",


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
		$response=$this->json('GET', '/api/user/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteUserFail()
	{
		$response=$this->delete('/api/user/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}