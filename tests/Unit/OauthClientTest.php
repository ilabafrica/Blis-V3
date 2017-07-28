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
        
			"created_by"=>1,
			"name"=>'Sample String',
			"secret"=>'Sample String',
			"redirect"=>'Sample String',
			"personal_access_client"=>1,
			"password_client"=>1,
			"revoked"=>1,

        );
    	$this->updatedoauthclientData=array(
            
            "created_by"=>1,
			"name"=>'Sample updated String',
			"secret"=>'Sample updated String',
			"redirect"=>'Sample updated String',
			"personal_access_client"=>1,
			"password_client"=>1,
			"revoked"=>1,

        );
	}

	public function testStoreOauthClient()
	{
		$response=$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by",$response->original);
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
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testUpdateOauthClient()
	{
		$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response=$this->json('PUT', '/api/oauthclient/1',$this->updatedoauthclientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("created_by",$response->original);
	}

	public function testDeleteOauthClient()
	{
		$this->json('POST', '/api/oauthclient',$this->oauthclientData);
		$response=$this->delete('/api/oauthclient/1');
		$response->assertStatus(200);
		$response=$this->json('GET', '/api/oauthclient/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}

	public function testDeleteOauthClientFail()
	{
		$response=$this->delete('/api/oauthclient/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}