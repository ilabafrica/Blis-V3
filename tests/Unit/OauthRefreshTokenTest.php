<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OauthRefreshTokenTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->oauthrefreshtokenData=array(
        

        );
    	$this->updatedoauthrefreshtokenData=array(
        

        );
	}

	public function testStoreOauthRefreshToken()
	{
		$response=$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListOauthRefreshToken()
	{
		$response=$this->json('GET', '/api/oauthrefreshtoken');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowOauthRefreshToken()
	{
		$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$response=$this->json('GET', '/api/oauthrefreshtoken/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateOauthRefreshToken()
	{
		$this->json('POST', '/api/oauthrefreshtoken',$this->updatedoauthrefreshtokenData);
		$response=$this->json('PUT', '/api/oauthrefreshtoken');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteOauthRefreshToken()
	{
		$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$response=$this->delete('/api/oauthrefreshtoken/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}