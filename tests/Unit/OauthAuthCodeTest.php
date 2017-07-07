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
        

        );
    	$this->updatedoauthauthcodeData=array(
        

        );
	}

	public function testStoreOauthAuthCode()
	{
		$response=$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",[$response->original]);
	}

	public function testListOauthAuthCode()
	{
		$response=$this->json('GET', '/api/oauthauthcode');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

	public function testShowOauthAuthCode()
	{
		$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		$response=$this->json('GET', '/api/oauthauthcode/1');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testUpdateOauthAuthCode()
	{
		$this->json('POST', '/api/oauthauthcode',$this->updatedoauthauthcodeData);
		$response=$this->json('PUT', '/api/oauthauthcode');
		$this->assertEquals(200,$response->getStatusCode());
		$this->assertArrayHasKey("subject",$response->original);
	}

	public function testDeleteOauthAuthCode()
	{
		$this->json('POST', '/api/oauthauthcode',$this->oauthauthcodeData);
		$response=$this->delete('/api/oauthauthcode/1');
		$this->assertEquals(200,$response->getStatusCode());
		
	}

}