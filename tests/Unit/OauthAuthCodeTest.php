<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OauthAuthCodeTest extends TestCase
{
	use DatabaseMigrations;

	public function setup(){
		parent::Setup();
		$this->setVariables();
	}

	public function setVariables(){
    	$this->oauthauthcodeData=array(
            
            "created_by"=>1,
            "client_id"=>1,
            "scopes"=>'Sample String',
            "revoked"=>1,
            

        );
    	$this->updatedoauthauthcodeData=array(
        
            "created_by"=>1,
            "client_id"=>1,
            "scopes"=>'Sample updated String',
            "revoked"=>1,
            
        );
	}

	public function testStoreOauthAuthCode()
	{
		$response=$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		// $response->assertStatus(200);
		// $this->assertArrayHasKey("scopes",$response->original);
	}

	public function testListOauthAuthCode()
	{
		$response=$this->json('GET', '/api/oauthauthcode');
		// $response->assertStatus(200);
		
	}

	public function testShowOauthAuthCode()
	{
		$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		$response=$this->json('GET', '/api/oauthauthcode/1');
		// $response->assertStatus(200);
		// $this->assertArrayHasKey("created_by",$response->original);
	}

	public function testUpdateOauthAuthCode()
	{
		$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		$response=$this->json('PUT', '/api/oauthauthcode/1',$this->updatedoauthauthcodeData);
		// $response->assertStatus(200);
		// $this->assertArrayHasKey("created_by",$response->original);
	}

	public function testDeleteOauthAuthCode()
	{
		$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		$response=$this->delete('/api/oauthauthcode/1');
		// $response->assertStatus(200);
		$response=$this->json('GET', '/api/oauthauthcode/1');
		// $this->assertEquals(404, $response->getStatusCode());
		
	}
	public function testDeleteOauthAuthCodeFail()
	{
		$response=$this->delete('/api/oauthauthcode/9999999999');
		// $this->assertEquals(404, $response->getStatusCode());
	}


}