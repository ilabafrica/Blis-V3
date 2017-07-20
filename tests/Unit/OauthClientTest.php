<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OauthClientTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->oauthclientData=array(
        
			"name"=>'Sample String',

        );
    	$this->updatedoauthclientData=array(
        
			"name"=>'Sample updated String',

        );
	}

	public function testStoreOauthClient()
	{
		$response=$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",[$response->original]);
	}

	public function testListOauthClient()
	{
		$response=$this->json('GET', '/api/oauthclient');
		$response->assertStatus(200);
		
	}

	public function testShowOauthClient()
	{
		$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response=$this->json('GET', '/api/oauthclient/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testUpdateOauthClient()
	{
		$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response=$this->json('PUT', '/api/oauthclient/1',$this->updatedoauthclientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("name",$response->original);
	}

	public function testDeleteOauthClient()
	{
		$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response=$this->delete('/api/oauthclient/1');
		$response->assertStatus(200);
		
	}

}