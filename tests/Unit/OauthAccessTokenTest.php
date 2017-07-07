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
        
			"name"=>'Sample String',

        );
    	$this->updatedoauthaccesstokenData=array(
        
			"name"=>'Sample updated String',

        );
	}

	public function testStoreOauthAccessToken()
	{
		$response=$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListOauthAccessToken()
	{
		$response=$this->json('GET', '/api/oauthaccesstoken');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowOauthAccessToken()
	{
		$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$response=$this->json('GET', '/api/oauthaccesstoken/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateOauthAccessToken()
	{
		$this->json('POST', '/api/oauthaccesstoken',$this->updatedoauthaccesstokenData);
		$response=$this->json('PUT', '/api/oauthaccesstoken');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteOauthAccessToken()
	{
		$this->json('POST', '/api/oauthaccesstoken',$this->oauthaccesstokenData);
		$response=$this->delete('/api/oauthaccesstoken/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}