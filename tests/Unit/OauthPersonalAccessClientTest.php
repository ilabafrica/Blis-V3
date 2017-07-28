<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OauthPersonalAccessClientTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->oauthpersonalaccessclientData=array(
              
              "client_id"=>1,


        );
    	$this->updatedoauthpersonalaccessclientData=array(
              
              "client_id"=>2,

        );
	}

	public function testStoreOauthPersonalAccessClient()
	{
		$response=$this->json('POST', '/api/oauthpersonalaccessclient',$this->oauthpersonalaccessclientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("client_id",$response->original);
	}

	public function testListOauthPersonalAccessClient()
	{
		$response=$this->json('GET', '/api/oauthpersonalaccessclient');
		$response->assertStatus(200);
		
	}

	public function testShowOauthPersonalAccessClient()
	{
		$this->json('POST', '/api/oauthpersonalaccessclient',$this->oauthpersonalaccessclientData);
		$response=$this->json('GET', '/api/oauthpersonalaccessclient/1');
		$response->assertStatus(200);
		$this->assertArrayHasKey("client_id",$response->original);
	}

	public function testUpdateOauthPersonalAccessClient()
	{
		$this->json('POST', '/api/oauthpersonalaccessclient',$this->oauthpersonalaccessclientData);
		$response=$this->json('PUT', '/api/oauthpersonalaccessclient/1',$this->updatedoauthpersonalaccessclientData);
		$response->assertStatus(200);
		$this->assertArrayHasKey("client_id",$response->original);
	}

	public function testDeleteOauthPersonalAccessClient()
	{
		$this->json('POST', '/api/oauthpersonalaccessclient',$this->oauthpersonalaccessclientData);
		$response=$this->delete('/api/oauthpersonalaccessclient/1');
		$this->assertEquals(200,$response->getStatusCode());
		$response=$this->json('GET', '/api/oauthpersonalaccessclient/1');
		$this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteOauthPersonalAccessClientFail()
	{
		$response=$this->delete('/api/oauthpersonalaccessclient/9999999999');
		$this->assertEquals(404, $response->getStatusCode());
	}

}