<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTypeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->usertypeData=array(
        
			"name"=>'Sample String',
			"description"=>'Sample String',

        );
    	$this->updatedusertypeData=array(
        
			"name"=>'Sample updated String',
			"description"=>'Sample updated String',

        );
	}

	public function testStoreUserType()
	{
		$response=$this->json('POST', '/api/usertype',$this->usertypeData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testListUserType()
	{
		$response=$this->json('GET', '/api/usertype');
		$response->assertStatus(200);
		
	}

	public function testShowUserType()
	{
		$this->json('POST', '/api/usertype',$this->usertypeData);
		$response=$this->json('GET', '/api/usertype/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testUpdateUserType()
	{
		$this->json('POST', '/api/usertype',$this->usertypeData);
		$response=$this->json('PUT', '/api/usertype/1',$this->updatedusertypeData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("description",$response->original);
	}

	public function testDeleteUserType()
	{
		$this->json('POST', '/api/usertype',$this->usertypeData);
		$response=$this->delete('/api/usertype/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/usertype/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteUserTypeFail()
	{
		$response=$this->delete('/api/patient/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}