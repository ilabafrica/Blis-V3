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
        
         "access_token_id"=>'Sample String',
         "revoked"=>1,
        );
    	$this->updatedoauthrefreshtokenData=array(
        
        "access_token_id"=>'Sample updated String',
         "revoked"=>1,
        );
	}

	public function testStoreOauthRefreshToken()
	{
		$response=$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("revoked",$response->original);
	}

	public function testListOauthRefreshToken()
	{
		$response=$this->json('GET', '/api/oauthrefreshtoken');
		$response->assertStatus(200);
		
	}

	public function testShowOauthRefreshToken()
	{
		$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$response=$this->json('GET', '/api/oauthrefreshtoken/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("access_token_id",$response->original);
	}

	public function testUpdateOauthRefreshToken()
	{
		$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$response=$this->json('PUT', '/api/oauthrefreshtoken/1',$this->updatedoauthrefreshtokenData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("access_token_id",$response->original);
	}

	public function testDeleteOauthRefreshToken()
	{
		$this->json('POST', '/api/oauthrefreshtoken',$this->oauthrefreshtokenData);
		$response=$this->delete('/api/oauthrefreshtoken/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/oauthrefreshtoken/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteOauthRefreshTokenFail()
	{
		$response=$this->delete('/api/oauthrefreshtoken/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}