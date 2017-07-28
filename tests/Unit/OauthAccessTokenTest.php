<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OauthAccessTokenTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->oauthaccesstokenData=array(
    		
            "created_by"=>1,
			"client_id"=>1,
			"name"=>'Sample String',
			"scopes"=>'Sample String',
			"revoked"=>'true',
			"expires_at"=>'2017:12:12 15:30:00',


        );
    	$this->updatedoauthaccesstokenData=array(
            
            "created_by"=>1,
			"client_id"=>1,
			"name"=>'Sample updated String',
			"scopes"=>'Sample updated String',
			"revoked"=>'true',
			"expires_at"=>'2017:12:12 15:30:00',


        );
	}

	public function testStoreOauthAccessToken()
	{
		$response=$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testListOauthAccessToken()
	{
		$response=$this->json('GET', '/api/oauthaccesstoken');
		$response->assertStatus(200);
		
	}

	public function testShowOauthAccessToken()
	{
		$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$response=$this->json('GET', '/api/oauthaccesstoken/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testUpdateOauthAccessToken()
	{
		$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$response=$this->json('PUT', '/api/oauthaccesstoken/1',$this->updatedoauthaccesstokenData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testDeleteOauthAccessToken()
	{
		$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$response=$this->delete('/api/oauthaccesstoken/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/oauthaccesstoken/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteOauthAccessTokenFail()
	{
		$response=$this->delete('/api/oauthaccesstoken/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}
   
}