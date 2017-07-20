<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PasswordResetTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->passwordresetData=array(
        
			"email"=>'Sample String',
			"token"=>'Sample String',

        );
    	$this->updatedpasswordresetData=array(
        
			"email"=>'Sample updated String',
			"token"=>'Sample updated String',

        );
	}

	public function testStorePasswordReset()
	{
		$response=$this->json('POST', '/api/passwordreset',$this->passwordresetData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("token",$response->original);
	}

	public function testListPasswordReset()
	{
		$response=$this->json('GET', '/api/passwordreset');
		$response->assertStatus(200);
		
	}

	public function testShowPasswordReset()
	{
		$this->json('POST', '/api/passwordreset',$this->passwordresetData);
		$response=$this->json('GET', '/api/passwordreset/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testUpdatePasswordReset()
	{
		$this->json('POST', '/api/passwordreset',$this->passwordresetData);
		$response=$this->json('PUT', '/api/passwordreset/1',$this->updatedpasswordresetData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("email",$response->original);
	}

	public function testDeletePasswordReset()
	{
		$this->json('POST', '/api/passwordreset',$this->passwordresetData);
		$response=$this->delete('/api/passwordreset/1');
		$response->assertStatus(200);
		
	}

}